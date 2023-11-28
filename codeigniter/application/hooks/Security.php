<?php
    class Security {
        public function role_check() {
            //if in development return
            if (ENVIRONMENT == 'development') {
                return;
            }

            $ci = &get_instance();
            $target = implode('/', $ci->uri->segment_array());
            
            //if target is not api/* and not api/v1/open/* then return
            if (strpos($target, 'api') === false || strpos($target, 'api/v1/open') !== false) {
                return;
            }

            $ci->load->model('Modelsession');
            $ci->load->model('Modeluser');

            //check user session in database
            $session = $ci->session->userdata('session_id');
            $satpam_whitelist = [
                'api/v1/location/single',
                'api/v1/scan/create',
                'api/v1/location/get',
                'api/v1/scan/mine',
                'api/v1/user/my',
                'api/v1/user/logout'
            ];

            if ($ci->Modelsession->verify($session)) {
                $user_role = $ci->Modeluser->get_role($ci->session->userdata('user_id'));
                if($user_role == 'SATPAM'){
                    if(!in_array($target, $satpam_whitelist)){
                        json_reply(false, 'Unauthorized', array());
                        http_response_code(401);
                        exit;
                    }
                }
            } else {
                if ($target == 'page') {
                    //destroy session
                    $ci->session->sess_destroy();
                    redirect(site_url('auth'));
                } else {
                    json_reply(false, 'Unauthorized', array());
                    exit;
                }
                http_response_code(401);
                die();
            }
        }

        function json_reply($status, $message, $data = null) {
            $reply = array(
                'status' => $status,
                'message' => $message,
                'timestamp' => time(),
                'data' => $data
            );
            echo json_encode($reply, JSON_PRETTY_PRINT);
        }
    }
?>