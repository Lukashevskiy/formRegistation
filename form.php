<?php
    namespace Form;
    Class Form{
        private $filename = "./clients_list";
        private $sep = "\t";
        private $fields = [
            'data'=>'',
            'ip'=>'',
            'firstName' => '',
            'lastName'=> '',
            'email'=>'',
            'phone'=>'',
            'theme'=>'',
            'payment'=>'',
            'mailing'=>''];

        function __construct()
        {
            Form::validate_data();
        }

        public function validate_data()
        {
            $this->fields['time'] = date("d-m-y_h-m-s");
            $this->fields['ip'] = $_SERVER["REMOTE_ADDR"];
            foreach ($_POST as $field_name => $value){
                $this->fields[$field_name] = htmlspecialchars($value) ?? null;
            }
            $this->fields['mailing'] = ($_POST["mailing"]  ?? null) == 0 ? 'Нет': 'Да';
        }

        public function get_field($field_name): string
        {
            return $this->fields[$field_name];
        }

        public function write_data(){
            file_put_contents($this->filename, Form::get_data(), FILE_APPEND);
        }

        public function is_empty_field($field_name): bool
        {
            return empty($form[$field_name]);
        }

        public function empty_fields() : array
        {
            $errors = [];
            foreach($this->fields as $key => $value){
                if($value == ''){
                    $errors[] = $key;
                }
            }
            return $errors;
        }

        public function get_data(): string
        {
            $ans = '';
            foreach ( $this->fields as $field_name => $value){
                $ans = $ans . $this->sep . $value;
            }
            return $ans . PHP_EOL;
        }
    }


