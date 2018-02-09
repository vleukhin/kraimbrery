<?php

namespace App\Controllers;

use \Fenom;

class Moderka
{
    private $fenom;
    private $config;

    public function __construct()
    {
        $this->config = Config::setting()->get();
        $this->fenom = new Fenom(new Fenom\Provider($this->config['template_dir_moderka']));
        $this->fenom->setCompileDir($this->config['template_cache_moderka']);
        $options['disable_cache'] = true;
        $this->fenom->setOptions($options);
    }

    private function arrSort($a, $b)
    {
        if ($a['date'] == $b['date']) {
            return 0;
        }

        return $a['date'] > $b['date'] ? 1 : -1;
    }

    public function AfiAction($action = '', $id = '')
    {
        $afi = dirname(__FILE__).'/../afi.php';
        $vars = require($afi);
        if ($action == 'add' && !empty($_POST['c'])) {
            $add_afi = $_POST['c'];
            if (is_array($add_afi)) {
                foreach ($add_afi as $k => $item) {
                    $add_afi[$k] = trim($item);
                }
                $vars['list']['id_'.str_replace('.', '', microtime(true))] = $add_afi;
                file_put_contents(
                    $afi,
                    '<? '.PHP_EOL.' return '.var_export($vars, true).';'
                );
            }
            header('location: /moderka/afi/');
            exit();
        } elseif ($action == 'del' && isset($id) && !empty($vars['list'])) {
            unset($vars['list'][$id]);
            file_put_contents(
                $afi,
                '<? '.PHP_EOL.' return '.var_export($vars, true).';'
            );
            header('location: /moderka/afi/');
            exit();
        }
        if (!empty($vars['list'])) {
            uasort($vars['list'], array($this, 'arrSort'));
        }

        $vars['events'] = [];

        foreach ($vars['list'] as $id => $event)
        {
            $vars['events'][] = array_merge($event, [
                'id' => $id,
            ]);
        }

        $this->fenom->display('afi.tpl', $vars);
    }

    public function AfiUpdateAction($id)
    {
        $file = dirname(__FILE__).'/../afi.php';

        $vars = require(dirname(__FILE__).'/../afi.php');

        $data = @json_decode(file_get_contents('php://input'), true);

        if (isset($vars['list'][$id]) and isset($data['event'])){
            unset($data['event']['id']);
            $vars['list'][$id] = $data['event'];

            file_put_contents(
                $file,
                '<? '.PHP_EOL.' return '.var_export($vars, true).';'
            );
        }
    }

    public function ImgAction($type, $action = '', $file = '')
    {
        if (in_array($type, array('slider', 'photo'))) {
            $slides = require (dirname(__FILE__).'/../slider.php');

            $msg_error = '';
            $path = dirname(__FILE__).'/../../uploads/'.$type.'/';
            if ($action == 'del') {
                $file = str_replace('..', '', $file);
                if (file_exists($path.$file) && is_file($path.$file)) {
                    unlink($path.$file);
                }
                unset($slides['$file']);
                $this->saveSlides($slides);

            } elseif ($action == 'add' && !empty($_FILES[$type]['name'][0])) {

                $upload = $this->uploadFiles(
                    $_FILES[$type],
                    $type
                );
                if (!empty($upload['errors'])) {
                    $msg_error = implode('<br>', $upload['errors']);
                }
                $this->saveSlides($slides);

            }
            elseif($action == 'save'){
                if (!empty($_POST['image']) and !empty($_POST['link'])){
                    $slides[$_POST['image']] = $_POST['link'];
                }
                $this->saveSlides($slides);
            }

            $vars = array(
                'c' => $this->config,
                'msg_error' => $msg_error,
            );
            $dir = opendir($path);
            while (false !== ($element = readdir($dir))) {
                if ($element != '.' AND $element != '..') {
                    $vars['list'][] = [
                        'image' => $element,
                        'link'  => $slides[basename($element)] ?? '',
                    ];
                }
            }
            $this->fenom->display($type.'.tpl', $vars);
        } else {
            Error::runStatic()->E404Action();
        }
    }

    protected function saveSlides($slides)
    {
        file_put_contents(
            dirname(__FILE__).'/../slider.php',
            '<? '.PHP_EOL.' return '.var_export($slides, true).';'
        );

        header('location: /moderka/img/slider/');
        exit();
    }


    public function MainAction()
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
                    $f_path = dirname(__FILE__).'/../..'.$this->config['who_is_she_img'];
                    if (file_exists($f_path)) {
                        unlink($f_path);
                    }
                    $post['who_is_she_img'] = $upload['file'];
                }
            }
            if (!empty($_FILES['audio']['size'])) {
                $upload = $this->uploadFile(
                    $_FILES['audio']['tmp_name'],
                    'audio',
                    $_FILES['audio']['name']
                );
                if (!empty($upload['file'])) {
                    $f_path = dirname(__FILE__).'/../..'.$this->config['audio'];
                    if (file_exists($f_path)) {
                        unlink($f_path);
                    }
                    $post['audio'] = $upload['file'];
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
        $vars = array(
            'c' => $this->config,
        );

        $this->fenom->display('setting.tpl', $vars);
    }

    private function uploadFiles($files, $type)
    {
        $errorMessages = array(
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
        );
        $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

        if (is_array($files['tmp_name'])) {
            $arrFilePath = $files['tmp_name'];
            $errorCode = $files['error'];
            $result = array(
                'error' => array(),
                'ok_count' => 0,
                'count' => count($files['tmp_name']),
            );

            foreach ($arrFilePath as $key => $filePath) {
                if ($errorCode[$key] != 0 || !is_uploaded_file($filePath)) {
                    $result['errors'][] = $filePath.' - '.isset($errorMessages[$errorCode[$key]]) ? $errorMessages[$errorCode[$key]] : $unknownMessage;
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
                $result['errors'][] = $files['name'].' - '.isset($errorMessages[$errorCode[$files['error']]]) ? $errorMessages[$files['error']] : $unknownMessage;
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
                $result['errors'][] = $o_filename.' - '.'Высота изображения не должна превышать 600 точек.';
            }
            if ($image[0] > $limitWidth) {
                $result['errors'][] = $o_filename.' - '.'Ширина изображения не должна превышать 980 точек.';
            }
            $extension = image_type_to_extension($image[2]);
            $format = str_replace('jpeg', 'jpg', $extension);
        } elseif ($type == 'audio') {
            $format = '.mp3';
        }
        if (!empty($format)) {
            $limitBytes = 1024 * 1024 * 5;
            if (filesize($filePath) > $limitBytes) {
                $result['errors'][] = $o_filename.' - '.'Размер изображения не должен превышать 5 Мбайт.';
            }
            $name = md5_file($filePath);

            $filename = str_replace('.', '', microtime(true)).$name.$format;
            if (!move_uploaded_file($filePath, dirname(__FILE__).'/../../uploads/'.$type.'/'.$filename)) {
                $result['error'] = $o_filename.' - '.'При записи изображения на диск произошла ошибка.';
            } else {
                $result['file'] = '/uploads/'.$type.'/'.$filename;
            }
        } else {
            $result['error'] = $o_filename.' - '.'Не удалосьопределить формат';
        }

        return $result;
    }
}