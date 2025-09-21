<?php
class Setting {
    private $db;
    public function __construct(){ $this->db = Database::getInstance(); }
    public function get(){
        $r = $this->db->query('SELECT * FROM settings LIMIT 1')->fetch();
        if(!$r){
            // create default row
            $s=$this->db->prepare('INSERT INTO settings (company_name,company_email,company_phone,company_address,company_ruc,logo_path) VALUES (?,?,?,?,?,?)');
            $s->execute([COMPANY_DEFAULT_NAME,COMPANY_DEFAULT_EMAIL,COMPANY_DEFAULT_PHONE,'','', '']);
            $r = $this->db->query('SELECT * FROM settings LIMIT 1')->fetch();
        }
        return $r;
    }
    public function update($data){
        $s=$this->db->prepare('UPDATE settings SET company_name=?, company_email=?, company_phone=?, company_address=?, company_ruc=?, logo_path=? WHERE id=?');
        return $s->execute([$data['company_name'],$data['company_email'],$data['company_phone'],$data['company_address'],$data['company_ruc'],$data['logo_path'],$data['id']]);
    }
}
?>
