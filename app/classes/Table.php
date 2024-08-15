<?php
class Table{
   public function showLine(string $name, string $value){
    if($value === NULL){
        echo 'لا معلومة';
    }
	else{
        if(str_contains($name, '_BOOL')){
            echo ($value == '1') ? 'نعم' : 'لا';
        }elseif(str_contains($name, '_URL')){
            echo '<a href="'.$value.'" target="_blank">'.$value.'</a>';
        }elseif(str_contains($name, '_CURRENCY')){
            echo ($value) ? $value . ' د.م' : 'بدون';
        }elseif(str_contains($name, '_TEXT')){
			echo '<div>'.$value.'</div>';
		}
        else{
            echo $value;
        }
    }
    
   } 
}