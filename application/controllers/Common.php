<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Controller {

    public $loginId;

    function __construct() {
        parent::__construct();
        $this->loginId = $this->session->userdata('shohozit_user_id');
        if (empty($this->loginId)) {
            redirect('authenticationcontroller');
        }
        $this->load->model('inventorymodel');
    }

    /* Al Amin work start */

    function get_lc_id() {
        $lcID = $this->input->post('lcID');
        $list = $this->db->get_where('lc', array('id' => $lcID))->row_array();
       echo json_encode($list);
    }

    /* Al Amin work End */

    function getRow() {
        $where = array();
        $order_by = '';
        $limit = '';
        $select = $this->input->post('select');
        $table = $this->input->post('table');
        if ($this->input->post('where')) {
            $where = $this->input->post('where');
        }
        if ($this->input->post('order_by')) {
            $order_by = $this->input->post('order_by');
        }
        if ($this->input->post('limit')) {
            $limit ='1';
        }
        echo json_encode($this->common_model->get_row($select, $table, $where, $order_by, $limit));
    }

    function chkDuplicacy() {
        $select = ltrim($this->input->post('select'), ' ');
        $table = $this->input->post('table');
        $where = $this->input->post('where');
        $row = $this->common_model->get_row($select, $table, $where);
        if ($row) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function chkDuplicacyEdit() {
        $select = ltrim($this->input->post('select'), ' ');
        $table = $this->input->post('table');
        $array = $this->input->post('where');
        $key = (array_keys($array));
        $where = array($key[0] => $array[$key[0]], $key[1] . '!=' => $array[$key[1]]);
        if (!empty($key[2])) {
            $key2 = $key[2];
            $val2 = $array[$key[2]];
            $where = array($key[0] => $array[$key[0]], $key[1] . '!=' => $array[$key[1]], $key[2] => $array[$key[2]]);
        }

        $row = $this->common_model->get_row($select, $table, $where);
        if ($row) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function get_state() {
        $id = $_POST['id'];
        $results = $this->common_model->get_result('q.id, q.quotation_id, q.status', 'quotation as q', 'id DESC', array('client_id' => $id, 'type' => 0));

        echo '<option selected="" disabled="">Select Quotation</option>';
        foreach ($results as $row) {
            ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['quotation_id']; ?>
            </option>
            <?php
        }
    }

    function dbExport() {
        $data['title'] = 'Database Backup';
        $data['dashboardContent'] = $this->load->view('dbBackup/dbExport', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function dbBackup() {
        $format = $this->input->post('format');
        $this->load->dbutil();
        $db_name = 'dipsyl ' . date('F d, Y _ g-i-s A') . '.' . $format;
        $prefs = array('format' => $format, 'filename' => $db_name);
        $backup = & $this->dbutil->backup($prefs);

        $save = 'C:\SoftwareBackup/' . $db_name;
        $this->load->helper('file');
        //write_file($save, $backup); 
        $this->load->helper('download');
        force_download($db_name, $backup);
        $this->session->set_flashdata('success', 'Database has been backed up into' . $save);
        redirect('common/dbExport');
    }

    function exportInventory() {
        $data = $this->inventorymodel->inventory_all_item();
        $filename = "all_item_" . date('Ymd') . ".xls";
        $this->exportData($data, $filename);
    }

    function exportData($data, $filename) {

        function cleanData(&$str) {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if (strstr($str, '"'))
                $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
//        $filename = "website_data_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\r\n";
                $flag = true;
            }
            array_walk($row, __NAMESPACE__ . '\cleanData');
            echo implode("\t", array_values($row)) . "\r\n";
        }
    }

}
