<?php
class ControllerExtensionModuleHTMLExt extends Controller {
    public function index($setting) {
        if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
            $data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
            $code = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');

            $code = preg_replace('/^\s*<\?php/', '', $code);
            $code = preg_replace('/\?>\s*$/', '', $code);
            $output = "";
            ob_start();
            try {
                eval($code);
                $output = ob_get_clean();
            } catch (ParseError $e) {
                ob_end_clean();
                return "fuck error: " . $e->getMessage();
            }


            $data['code'] = $code;
            $data['result'] = $output;

            return $this->load->view('extension/module/html_ext', $data);
        }
    }

}