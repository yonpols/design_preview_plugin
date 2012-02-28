<?php
    namespace DesignPreview;

    class MainController extends \YPFControllerBase {
        protected $layouts = array();
        protected $views = array();

        public function index() {
            $this->output->layout = 'design_preview/main';

            $this->searchFiles();
            $this->data->layouts = $this->layouts;
            $this->data->views = $this->views;
        }

        public function preview() {
            error_reporting(error_reporting() & ~E_NOTICE);
            error_reporting(error_reporting() & ~E_WARNING);

            $this->output->layout = $this->param('layout');
            $this->render($this->param('view_name'));
        }

        private function searchFiles($parent = null, $isLayout = false) {
            $files = \YPFramework::getComponentPath('*', \YPFramework::getFileName('views', $parent), true, true);

            if (!$files)
                return;
            
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $basename = basename($file);
                    $this->searchFiles(\YPFramework::getFileName($parent, $basename), $isLayout || ($basename == '_layouts'));
                } else {
                    $pos = strrpos($file, '/');
                    $pos = stripos($file, '.', $pos+1);
                    $file = substr($file, 0, $pos);

                    if (($ipos = strpos($file, '/extensions/')) !== false) {
                        $fpos = strpos($file, '/views/');
                        $comment = ' ('.substr($file, $ipos+12, $fpos-$ipos-12).')';
                    } else
                        $comment = '';

                    if ($isLayout) {
                        $pos = strrpos($file, '/_layouts/');
                        $file = substr($file, $pos+10);
                        $this->layouts[$file] = $file.$comment;
                    } else {
                        $pos = strrpos($file, '/views/');
                        $file = substr($file, $pos+7);
                        $this->views[$file] = $file.$comment;
                    }
                }
            }
        }
    }
?>
