<?php
namespace Inside4\InsideAutoTables\Inputs;

class Translate_form {


	public function input_form($input_array, $cell_id)
	{
		$db =& $GLOBALS['Commons']['db'];
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

		if ($input_array['make_type'] == 'edit')
		{
			$data = '';

			$res = $db->sql_get_data("SELECT * from ".$input_array['table']." WHERE ".$input_array['lang_alias_column']." = 'ru' AND ".$input_array['id_column']." = ".intval($cell_id)." LIMIT 1");

			if (isset($res[0]))
			$translate_row = $res[0];
			
			$data .= "<input type='hidden' value='".intval($cell_id)."' name='".$input_array['id_column']."' />";
			$data .= "<select name='".$input_array['lang_alias_column']."'>";
			$data .= "<option value='ru'>Русский</option>";
			$data .= "</select>";
			$data .= "<br />";
			foreach	($input_array['columns'] as $config) {
			
			if (isset($translate_row[$config['name']]))$config['value'] = $translate_row[$config['name']];
			else $config['value'] = "";
			$config['name'] = $config['name']."_ru";
			
			$config['make_type'] = 'edit';
			$data .= "<b>".$config['text']."</b>"."<br />".$at_system->make_input("input_form", $config)."<br /><br />";
			}
			
			return $data;
		}
		else return "Translates plz, add it in Edit window...";
	}
	public function db_save($input_array, $cell_id)
	{

		$db =& $GLOBALS['Commons']['db'];

		$db->run_sql("DELETE FROM ".$input_array['table']." WHERE ".$input_array['lang_alias_column']." = 'ru' AND ".$input_array['id_column']." = ".intval($cell_id));
		
		foreach ($_POST as $key => $value)
		{
			if (substr($key, -3) == "_ru")  
				$_POST[substr($key, 0, -3)] = $value;
		}
		
		foreach ($_FILES as $key => $value)
		{
			if (substr($key, -3) == "_ru")  
				$_FILES[substr($key, 0, -3)] = $value;
		}
		
		$result = $CI->inside_model->insert_table_cell($input_array['table']);
		$input_view_data['message'] = $result;
		$CI->load->view('admin/adv/message', $input_view_data);

	}
	public function db_add($input_array, $cell_id)
	{
		
	}

}
