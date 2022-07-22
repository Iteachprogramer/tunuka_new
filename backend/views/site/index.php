<?php

use common\models\Client;
use soft\widget\adminlte3\Card;

/* @var $this yii\web\View */
/* @var $clientsList array List of clients  */
/* @var $allClients Client[] */

$this->title = 'Bosh sahifa';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(' 
    td { white-space: nowrap!important; } 
    .serial-column-cell { width:30px }
    ');
?>

<?= $this->render('_totalAccountBoxes', ['allClients' => $allClients]) ?>

<?php

$js = <<<JS

    $(document).on('keyup', '#client_name_input', function(e){
        filter_clients()
    })
    
    $(document).on('change', '#client_type_select', function(e){
        filter_clients()
    })
     
     $(document).on('submit', '#client_filter_form', function(e){
        e.preventDefault()
        filter_clients()
    })
     
      function filter_clients(){
         let client_form = $('#client_filter_form')
        $.ajax({
            url: client_form.attr('action'),
            data: client_form.serialize(),
            success: function(result){
                $('#clients-table-container').html(result)
            }
        })
    }
    
     $(document).on('click', '#reset_filter_button', function(e){
        e.preventDefault()
        let client_form = $('#client_filter_form')
        $.ajax({
            url: $(this).attr('href'),
            success: function(result){
                $('#clients-table-container').html(result)
                client_form.trigger('reset')
            }
        })
    })
    
   
JS;

$this->registerJs($js);

?>



