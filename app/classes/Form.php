<?php

class Form
{
    private string $title;
    private array $line_names; //associative table contaning the names and the shown names as ['name' => 'the name of association']
    private function insert(string $id, string $name, string $placeholder = null, mixed $value = null): string
    {
        /**
         * PN that the $value variable could be a string but also an array containning an array (of data) and the name that
         * should be shown in the select first option : $value = array(array $data, string $header)
         */
        try{
                if(str_contains(htmlentities($name), '_NUM')){
                    return '<input type="number" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'" required>';
                }
                    
                elseif(str_contains(htmlentities($name), '_DATE')){
                    return '<input type="date" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'" required>';
                }
                    

                elseif(str_contains(htmlentities($name), '_BOOL')){
                    return '<input type="radio" id="'.$id .'" name="'.htmlentities($name).'" value="'.htmlentities($value).'" required>';
                }
                    

                elseif(str_contains(htmlentities($name), '_TEXT')){
                    return '<textarea type="date" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'"></textarea>';
                }
                    

                elseif(str_contains(htmlentities($name), '_REGULAR')){
                    return '<input type="text" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'">';
                }
				elseif(str_contains(htmlentities($name), '_NAME')){
                    return '<input type="text" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'" required>';
                }

                elseif(str_contains(htmlentities($name), '_FOR')){
                    $text = '<select id="'.$id.'" name="'.htmlentities($name).'" required><option value="">'.htmlentities($value[1]).'</option>';
                    
                    foreach($value[0] as $choice){
                        $text .= '<option value="'.htmlentities($choice['_ID']).'">'.htmlentities($choice['_OPENname']).'</option>';
                    }
                    return $text . '</select>';
                }
                elseif(str_contains(htmlentities($name), '_TEL')){
                    return '<input type="tel" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'">';
                }
                elseif(str_contains(htmlentities($name), '_EMAIL')){
                    return '<input type="email" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'">';
                }
                elseif(str_contains(htmlentities($name), '_URL')){
                    return '<input type="url" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'" onblur="checkURL(this)">';
                }
                elseif(str_contains(htmlentities($name), '_CURRENCY')){
                    return '<input type="number" id="'.$id.'" name="'.htmlentities($name).'" placeholder="'.htmlentities($placeholder).'" step="any">';
                }
                else{
                    return 'OOps! We do not know which input type to show here';
                }
                
        }catch(Throwable $e){
            echo "OOOps ! We can't acess the inputs ! Check the files Form.php, index.php (except the one of public). Good luck !";
        }
        
    }
    private function isChecked($value, $last){
        if($value === $last){
            return 'checked';
        }else{
            return '';
        }
    }
    public function update(string $id, string $name, string $value = null, string $last = null): string
    {
        if(str_contains(htmlentities($name), '_OPEN')){

                if(str_contains(htmlentities($name), '_DATE')){
                    return '<input type="date" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'" disabled>';
                }elseif(str_contains(htmlentities($name), '_FOR')){
                    $text = '<select id="'.$id.'" name="" disabled><option value="">'.htmlentities($value).'</option>';
                    return $text . '</select>';
                }
            
                elseif(str_contains(htmlentities($name), '_TEXT')){
                    return '<textarea type="date" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'">' . htmlentities($value) . '</textarea>';
                }elseif(str_contains(htmlentities($name), '_NAME')){
                    return '<input type="text" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'" required>';
                }elseif(str_contains(htmlentities($name), '_REGULAR')){
                    return '<input type="text" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'">';
                }elseif(str_contains(htmlentities($name), '_BOOL')){
                    return '<input type="radio" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'" ' . $this -> isChecked(htmlentities($value), htmlentities($last)) . '>';
                }elseif(str_contains(htmlentities($name), '_NUM')){
                    return '<input type="number" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'">';
                }elseif(str_contains(htmlentities($name), '_TEL')){
                    return '<input type="tel" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'">';
                }
                elseif(str_contains(htmlentities($name), '_EMAIL')){
                    return '<input type="email" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'">';
                }
                elseif(str_contains(htmlentities($name), '_URL')){
                    return '<input type="url" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'" onblur="checkURL(this)">';
                }
                elseif(str_contains(htmlentities($name), '_CURRENCY')){
                    return '<input type="number" id="'.$id.'" name="'.htmlentities($name).'" value="'.htmlentities($value).'" step="any">';
                }
            
        }
    }

    public function insertForm(array $formInfo, string $formTitle){
        //As argument, it receives an object type Table and an array containting the ids and the texts associated with every input
        echo 
            '        <div class="modal" id="add"> 
            <div class="form">
            <table class="pop-up">
            <form action="" method="POST" id="add-form"><tr>
            <td>
            <h2>';
       
        echo $formTitle . '</h2></td></tr>';

        foreach($formInfo as $title => $properties){
            echo '<tr>';
                    if(str_contains($properties['name'], '_BOOL')){
                        echo '<td>';
                            echo '<label for="">' . $title . '</label>';
                        echo '</td>';
                        echo '<td>';
                            echo '<table>';
                                foreach($properties['choices'] as $label => $element){
                                    echo '<tr>';
                                    echo '<td>';
                                        echo '<label for="'. $element['id'] .'">' . $label . '</label>';
                                    echo '</td>';
                                    echo '<td>';
                                        echo $this -> insert($element['id'], $properties['name'], null, $element['value']);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            echo '</table>';
                        echo '</td>';
                    }else{
                        echo '<td>';
                            echo '<label for="'. $properties['id'] .'">' . $title . '</label>';
                        echo '</td>';
                        echo '<td>';
                            echo $this -> insert($properties['id'], $properties['name'], $properties['placeholder'] ?? null, $properties['value'] ?? null);
                        echo '</td>';
                    }
                        echo '</tr>';
        }

        echo '<tr>
            <td>
                <button type="submit" name="add" value="add" id="add-button">اضافة</button>
            </td>
            <td>
            </td>
            </tr>
            </form>';
        echo '<tr>
            <td>
            <button data-close-button class="close-button">خروج</button>
            </td>
            <td></td>
        </tr>
        </table>
        </div>
        </div>
        <div id="overlay"></div>';

    }
    
    public function updateForm(array $formInfo, array $formMeta, string $id){
        //As argument, it receives an object type Table and an array containting the ids and the texts associated with every input
        echo 
            '        <div class="modal" id="' . $id . '"> 
            <div class="form">
            <table class="pop-up">
            <form action="" method="POST" id="add-form"><tr>
            <td>
            <h2>';
       
        echo $formMeta[0] . '</h2></td></tr>';

        foreach($formInfo as $title => $properties){
            echo '<tr>';
                    if(str_contains($properties['name'], '_BOOL')){
                        echo '<td>';
                            echo '<label for="">' . $title . '</label>';
                        echo '</td>';
                        echo '<td>';
                            echo '<table>';
                                foreach($properties['choices'] as $label => $element){
                                    echo '<tr>';
                                    echo '<td>';
                                        echo '<label for="'. $element['id'] .'">' . $label . '</label>';
                                    echo '</td>';
                                    echo '<td>';
                                        echo $this -> update($element['id'], $properties['name'], $element['value'], $properties['value']);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            echo '</table>';
                        echo '</td>';
                    }else{
                        echo '<td>';
                            echo '<label for="'. $properties['id'] .'">' . $title . '</label>';
                        echo '</td>';
                        echo '<td>';
                            echo $this -> update($properties['id'], $properties['name'], $properties['value']);
                        echo '</td>';
                    }
                        echo '</tr>';
        }

        echo '<tr>
            <td>
                <button type="submit" name="edit" value="'. $formMeta[1] .'" id="edit-button">تعديل</button>
            </td>
            <td>
            </td>
            </tr>
            </form>';
        echo '</form>
        <tr>
            <td>
            <button data-close-button class="close-button">خروج</button>
            </td>
            <td></td>
        </tr>
        </table>
        </div>
        </div>
        <div id="overlay"></div>';

    }
}