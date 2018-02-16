<?php

namespace App\Controllers;

use \Fenom;
use Slim\Http\Request;
use Slim\Http\Response;

class Moderka
{
    private $fenom;
    private $config;

    public function __construct()
    {
        $this->config = Config::setting()->get();
        $this->fenom = new Fenom(new Fenom\Provider($this->config['template_dir_moderka']));
        $this->fenom->setCompileDir($this->config['template_cache']);
        $options['disable_cache'] = true;
        $this->fenom->setOptions($options);
    }

    public function ImgAction(Request $request, Response $response, array $args)
    {
        $type = $args['type'] ?? null;
        $action = $args['action'] ?? null;
        $file = $args['file'] ?? null;

        if (in_array($type, ['slider', 'photo'])) {
            $slides = require(dirname(__FILE__) . '/../' . $type . '.php');

            $msg_error = '';
            $path = dirname(__FILE__) . '/../../uploads/' . $type . '/';

            if ($action == 'del') {
                $file = str_replace('..', '', $file);
                if (file_exists($path . $file) && is_file($path . $file)) {
                    unlink($path . $file);
                }
                unset($slides['$file']);
                $this->saveSlides($slides, $type);

            } elseif ($action == 'add' && !empty($_FILES[$type]['name'][0])) {

                $upload = $this->uploadFiles(
                    $_FILES[$type],
                    $type
                );
                if (!empty($upload['errors'])) {
                    $msg_error = implode('<br>', $upload['errors']);
                }
                $this->saveSlides($slides, $type);

            } elseif ($action == 'save') {
                if (!empty($_POST['image']) and isset($_POST['link'])) {
                    $slides[$_POST['image']] = $_POST['link'];
                }
                $this->saveSlides($slides, $type);
            }

            $vars = [
                'c'         => $this->config,
                'msg_error' => $msg_error,
            ];
            $dir = opendir($path);
            while (false !== ($element = readdir($dir))) {
                if ($element != '.' AND $element != '..') {
                    $vars['list'][] = [
                        'image' => $element,
                        'link'  => $slides[basename($element)] ?? '',
                    ];
                }
            }
            $this->fenom->display($type . '.tpl', $vars);
        } else {
            Error::runStatic()->E404Action();
        }

        return $response;
    }

    protected function saveSlides($slides, $type)
    {
        file_put_contents(
            dirname(__FILE__) . '/../' . $type . '.php',
            '<? ' . PHP_EOL . ' return ' . var_export($slides, true) . ';'
        );

        header('location: /moderka/img/' . $type . '/');
        exit();
    }


    public function MainAction(Request $request, Response $response)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->config = Config::setting()->get();
            $post = $_POST['c'];
            if (!empty($_FILES['who_is_she_img']['size'])) {
                $upload = $this->uploadFile(
                    $_FILES['who_is_she_img']['tmp_name'],
                    'about',
                    $_FILES['who_is_she_img']['name']
                );
                if (!empty($upload['file'])) {
                    $f_path = dirname(__FILE__) . '/../..' . $this->config['who_is_she_img'];
                    if (file_exists($f_path)) {
                        unlink($f_path);
                    }
                    $post['who_is_she_img'] = $upload['file'];
                }
            }

            foreach (['audio', 'audio2', 'audio3'] as $audio) {
                if (!empty($_FILES[$audio]['size'])) {
                    $upload = $this->uploadFile(
                        $_FILES[$audio]['tmp_name'],
                        'audio',
                        $_FILES[$audio]['name']
                    );
                    if (!empty($upload['file'])) {
                        $f_path = dirname(__FILE__) . '/../..' . $this->config[$audio];
                        if (file_exists($f_path) and !empty($this->config[$audio])) {
                            unlink($f_path);
                        }
                        $post[$audio] = $upload['file'];
                    }
                }
            }

            $video_cover = $request->getUploadedFiles()['video_cover'] ?? null;

            if ($video_cover and $video_cover->getError() === UPLOAD_ERR_OK) {
                try {
                    if (file_exists(APP_ROOT . $this->config['video_cover']) and !empty($this->config['video_cover'])) {
                        unlink(APP_ROOT . $this->config['video_cover']);
                    }
                    $post['video_cover'] = 'uploads/video/' . moveUploadedFile(APP_ROOT . 'uploads/video/', $video_cover);
                } catch (\Exception $exception) {

                }
            }

            $post['who_is_she_head'] = nl2br($post['who_is_she_head']);
            $post['who_is_she_intro'] = nl2br($post['who_is_she_intro']);
            $post['who_is_she_full'] = nl2br($post['who_is_she_full']);
            Config::setting()->save($post);
        }
        $this->config = Config::setting()->get();
        $this->config['who_is_she_head'] = preg_replace('#<br\s*/?>#i', "", $this->config['who_is_she_head']);
        $this->config['who_is_she_intro'] = preg_replace('#<br\s*/?>#i', "", $this->config['who_is_she_intro']);
        $this->config['who_is_she_full'] = preg_replace('#<br\s*/?>#i', "", $this->config['who_is_she_full']);

        foreach ($this->config as $k => $v) {
            $this->config[$k] = htmlspecialchars($this->config[$k]);
        }
        $vars = [
            'c' => $this->config,
        ];

        $this->fenom->display('setting.tpl', $vars);
    }

    private function uploadFiles($files, $type)
    {
        $errorMessages = [
            /*UPLOAD_ERR_INI_SIZE*/
            1 => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
            /*UPLOAD_ERR_FORM_SIZE*/
            2 => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
            /*UPLOAD_ERR_PARTIAL*/
            3 => 'Загружаемый файл был получен только частично.',
            /*UPLOAD_ERR_NO_FILE*/
            4 => 'Файл не был загружен.',
            /*UPLOAD_ERR_NO_TMP_DIR*/
            5 => 'Отсутствует временная папка.',
            /*UPLOAD_ERR_CANT_WRITE*/
            6 => 'Не удалось записать файл на диск.',
            /*UPLOAD_ERR_EXTENSION*/
            7 => 'PHP-расширение остановило загрузку файла.',
        ];
        $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

        if (is_array($files['tmp_name'])) {
            $arrFilePath = $files['tmp_name'];
            $errorCode = $files['error'];
            $result = [
                'error'    => [],
                'ok_count' => 0,
                'count'    => count($files['tmp_name']),
            ];

            foreach ($arrFilePath as $key => $filePath) {
                if ($errorCode[$key] != 0 || !is_uploaded_file($filePath)) {
                    $result['errors'][] = $filePath . ' - ' . isset($errorMessages[$errorCode[$key]]) ? $errorMessages[$errorCode[$key]] : $unknownMessage;
                } else {
                    $res = $this->uploadFile($filePath, $type, $files['name'][$key]);
                }
                if (!empty($res['error'])) {
                    $result['errors'][] = $res['error'];
                } else {
                    $result['files'][] = $res['file'];
                    $result['ok_count']++;
                }
            }
        } else {
            if ($files['error'] != 0 || !is_uploaded_file($files['tmp_name'])) {
                $result['errors'][] = $files['name'] . ' - ' . isset($errorMessages[$errorCode[$files['error']]]) ? $errorMessages[$files['error']] : $unknownMessage;
            } else {
                $res = $this->uploadFile($files['tmp_name'], $type, $files['name']);
                $result['file'] = $res['file'];
            }

        }

        return $result;
    }

    private function uploadFile($filePath, $type, $o_filename)
    {
        if ($type == 'photo' || $type == 'about' || $type == 'slider') {
            $image = getimagesize($filePath);
            $limitWidth = 980;
            $limitHeight = 600;
            if ($image[1] > $limitHeight) {
                $result['errors'][] = $o_filename . ' - ' . 'Высота изображения не должна превышать 600 точек.';
            }
            if ($image[0] > $limitWidth) {
                $result['errors'][] = $o_filename . ' - ' . 'Ширина изображения не должна превышать 980 точек.';
            }
            $extension = image_type_to_extension($image[2]);
            $format = str_replace('jpeg', 'jpg', $extension);
        } elseif ($type == 'audio') {
            $format = '.mp3';
        }
        if (!empty($format)) {
            $limitBytes = 1024 * 1024 * 5;
            if (filesize($filePath) > $limitBytes) {
                $result['errors'][] = $o_filename . ' - ' . 'Размер изображения не должен превышать 5 Мбайт.';
            }
            $name = md5_file($filePath);

            $filename = str_replace('.', '', microtime(true)) . $name . $format;
            if (!move_uploaded_file($filePath, dirname(__FILE__) . '/../../uploads/' . $type . '/' . $filename)) {
                $result['error'] = $o_filename . ' - ' . 'При записи изображения на диск произошла ошибка.';
            } else {
                $result['file'] = '/uploads/' . $type . '/' . $filename;
            }
        } else {
            $result['error'] = $o_filename . ' - ' . 'Не удалосьопределить формат';
        }

        return $result;
    }

    public function removeVideoCover()
    {
        $this->config = Config::setting()->get();

        $this->config['video_cover'] = null;

        Config::setting()->save($this->config);
    }
}