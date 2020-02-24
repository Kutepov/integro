<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
    }

    .ui-autocomplete-input {
        width: 90%;
        border: none!important;
        background: none;
        outline: none;
    }

    .ui-button {
        border: none!important;
        outline: none;
        background: none;
    }
    #addprojectform-agreement {
        text-transform: none;
    }
</style>
<script>
    $( function() {
        $.widget( "custom.combobox", {
            _create: function() {
                this.wrapper = $( "<span>" )
                    .addClass( "custom-combobox" )
                    .insertAfter( this.element );

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function() {
                var selected = this.element.children( ":selected" ),
                    value = selected.val() ? selected.text() : "";

                this.input = $( "<input>" )
                    .appendTo( this.wrapper )
                    .val( value )
                    .attr( "title", "" )
                    .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy( this, "_source" )
                    })
                    .tooltip({
                        classes: {
                            "ui-tooltip": "ui-state-highlight"
                        }
                    });

                this._on( this.input, {
                    autocompleteselect: function( event, ui ) {
                        ui.item.option.selected = true;
                        this._trigger( "select", event, {
                            item: ui.item.option
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function() {
                var input = this.input,
                    wasOpen = false;

                $( "<a>" )
                    .attr( "tabIndex", -1 )
                    .attr( "title", "Показать всё" )
                    .tooltip()
                    .appendTo( this.wrapper )
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass( "ui-corner-all" )
                    .addClass( "custom-combobox-toggle ui-corner-right" )
                    .on( "mousedown", function() {
                        wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                    })
                    .on( "click", function() {
                        input.trigger( "focus" );

                        // Close if already visible
                        if ( wasOpen ) {
                            return;
                        }

                        // Pass empty string as value to search for, displaying all results
                        input.autocomplete( "search", "" );
                    });
            },

            _source: function( request, response ) {
                var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                response( this.element.children( "option" ).map(function() {
                    var text = $( this ).text();
                    if ( this.value && ( !request.term || matcher.test(text) ) )
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }) );
            },

            _removeIfInvalid: function( event, ui ) {

                // Selected an item, nothing to do
                if ( ui.item ) {
                    setManager();
                    setCEO();
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children( "option" ).each(function() {
                    if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if ( valid ) {
                    return;
                }

                // Remove invalid value
                this.input
                    .val( "" )
                    .attr( "title", value + " не найдено" )
                    .tooltip( "open" );
                this.element.val( "" );
                this._delay(function() {
                    this.input.tooltip( "close" ).attr( "title", "" );
                }, 2500 );
                this.input.autocomplete( "instance" ).term = "";
            },

            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });

        $( ".combobox" ).combobox();
    } );
</script>
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use app\models\Ptypes;
use app\models\User;
use app\models\Country;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Agreement;
use yii\jui\AutoComplete;
use yii\helpers\Url;
$this->title = 'Создание проекта';
$form = ActiveForm::begin();
$sti_c = '';
if (isset($_SESSION['isManager']) && !(isset($_SESSION['sti_edit_all']))) {
    $sti_c = 'style="display: none;"';
}
if (isset($_SESSION['isCEO']) && !(isset($_SESSION['sti_edit_all']))) {

}

if (isset($_GET['project'])) {
    $projectG = "?project=".$_GET['project'];
    $projectS = $_GET['project'];
}
else if (isset($_SESSION['idProject'])) {
    $projectS = $_SESSION['idProject'];
    $projectG = "";
}
else {
    $projectG = "";
    $projectS = "0";
}
echo"
	<style>
		select {
			text-transform:capitalize;
		}		
	</style>
	<div id=\"cForm\" style=\"width: 40%; margin: auto;\">	
		<div style=\"\">
			<p style=\"color: #2f475b;font-family: FSRAIL75;font-size: 1.125em;\"> Создание проекта</p>
		</div>
		<div>
			<div style=\"display: inline-block;width: 10em;\">
				<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;vertical-align: middle;\"> Полное название</p>
			</div>
			<div class=\"addProjectInputName\">";
echo $form->field($model, 'full_name',['enableLabel' => false])->textInput(array('class'=>'addProjectFormFieldTop'));
echo "
			</div>
		</div>
		<div style=\"width: 100%; margin-bottom: 0.625em;\"></div>
		<div style=\"width: 100%; margin-bottom: 1.5625em;\">";
echo "
			<div style=\"margin-bottom: 0.625em;\">
				<div style=\"display: inline-block;width: 10em;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;vertical-align: middle;\"> Вид проекта</p>
				</div>
				<div class=\"addProjectInput\">";
$params = [
    'prompt' => 'Выберите вид проекта', 'class'=>'addProjectFormField'
];
echo $form->field($model, 'type',['enableLabel' => false])->dropDownList(ArrayHelper::map(\app\models\ProjectsTypes::find()->all(), 'id', 'name'),$params);
echo "
				</div>
			</div>
			<div style=\"margin-bottom: 0.625em;\">
				<div style=\"display: inline-block;width: 10em;     vertical-align: middle;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;vertical-align: middle;\"> Страна</p>
				</div>
				<div class=\"addProjectInput\" style=\" text-transform:capitalize;\">";
$params = [
    'prompt' => 'Выберите страну', 'class'=>'addProjectFormField'
];
echo $form->field($model, 'country_id',['enableLabel' => false])->dropDownList(ArrayHelper::map(\app\models\Countries::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),$params);
echo "
				</div>
			</div>
			<div style=\"margin-bottom: 0.625em;\">
				<div style=\"display: inline-block;width: 10em;     vertical-align: middle;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em; vertical-align: middle; width: 95%;\"> Краткое наименование проекта</p>
				</div>
				<div class=\"addProjectInput\">";
echo $form->field($model, 'name',['enableLabel' => false])->textInput(array('class'=>'addProjectFormField'));
echo "
				</div>
			</div>
			<div style=\"margin-bottom: 0.625em;\">
				<div style=\"display: inline-block;width: 10em;vertical-align: middle;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;\"> Начало проекта</p>
				</div>
				<div class=\"addProjectInput\">";
echo $form->field($model, 'begin_at',['inputOptions' => ['autocomplete' => 'off'], 'enableLabel' => false])->widget(\yii\jui\DatePicker::class, ['language' => 'ru', 'dateFormat' => 'dd.MM.yyyy', 'options' => ['class' => 'addProjectFormField'], 'clientOptions' => ['changeMonth' => true, 'changeYear' => true,],]);
echo "
				</div>
			</div>
			<div style=\"margin-bottom: 0.625em;\">
				<div style=\"display: inline-block;width: 10em;vertical-align: middle;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;\"> Завершение проекта</p>
				</div>
				<div class=\"addProjectInput\">";
echo $form->field($model, 'end_at',['inputOptions' => ['autocomplete' => 'off'], 'enableLabel' => false])->widget(\yii\jui\DatePicker::class, ['language' => 'ru','dateFormat' => 'dd.MM.yyyy', 'options' => ['class' => 'addProjectFormField'], 'clientOptions' => ['changeMonth' => true, 'changeYear' => true,],]);
echo "
				</div>
			</div>";
echo "
			<div ".$sti_c.">
				<div style=\"margin-bottom: 0.625em;\">
					<div style=\"display: inline-block;width: 10em; vertical-align: middle;\">
						<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;\"> Руководитель</p>
					</div>
					<div class=\"addProjectInput\">";
$params = [
    'prompt' => 'Выберите пользователя', 'class'=>'addProjectFormField'
];
$ceoval = '';
if (!empty($model->ceo)) {
    $rows = (new \yii\db\Query())
        ->select(['nameUserFull'])
        ->from('tbl_users')
        ->where(['idUser' => $model->ceo])
        ->all();
    foreach ($rows as $row) {
        $ceoval = $row['nameUserFull'];
    }
}
//echo $form->field($model, 'ceo',['enableLabel' => false])->dropDownList(ArrayHelper::map(User::find()->all(), 'idUser', 'nameUserFull'),$params);
echo $form->field($model, 'ceo',['enableLabel' => false])->hiddenInput();
/*echo AutoComplete::widget([
    'value' => (!empty($model->ceo) ? $ceoval : ''),
    'options' => [
        'placeholder'=> 'Выберите пользователя',
        'class'=>'addProjectFormField',
    ],
    'clientOptions' => [
        'source' => Url::toRoute('autocompleteuser'),
        'minLength'=>'3',
        'dataType'=>'json',
        'select' => new yii\web\JsExpression("function( event, ui ) {setCEO(ui.item.id);}")
    ],]);*/
echo "
						<div class=\"ui-widget\">
							<select id=\"selCEO\" class=\"combobox\" onchange=\"setCEO();\">
								<option value=\"\">Выберите пользователя</option>";
$rows = (new \yii\db\Query())
    ->select(['id','full_name'])
    ->from('users')
    ->all();
foreach ($rows as $row) {
    $selectedCEO = "";
    if ($model->ceo_id == $row['id']) {
        $selectedCEO = 'selected';
    }
    echo "<option ".$selectedCEO." value=\"".$row['id']."\">".$row['full_name']."</option>";
}
echo "
							 </select>
						</div>
					</div>
				</div>
				<div style=\"margin-bottom: 0.625em;\">
					<div style=\"display: inline-block;width: 10em; vertical-align: middle;\">
						<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;\"> Проектный менеджер</p>
					</div>
					<div class=\"addProjectInput\">";
$params = [
    'prompt' => 'Выберите пользователя', 'class'=>'addProjectFormField'
];
$managerval = '';
if (!empty($model->manager)) {
    $rows = (new \yii\db\Query())
        ->select(['full_name'])
        ->from('users')
        ->where(['id' => $model->manager_id])
        ->all();
    foreach ($rows as $row) {
        $managerval = $row['full_name'];
    }
}
//echo "managerval = $managerval";
//echo $form->field($model, 'manager',['enableLabel' => false])->dropDownList(ArrayHelper::map(User::find()->all(), 'idUser', 'nameUserFull'),$params);
echo $form->field($model, 'manager',['enableLabel' => false])->hiddenInput();
/*echo AutoComplete::widget([
    'value' => (!empty($model->manager) ? $managerval : ''),
    'options' => [
        'placeholder'=> 'Выберите пользователя',
        'class'=>'addProjectFormField',
    ],
    'clientOptions' => [
        'source' => Url::toRoute('autocompleteuser'),
        'minLength'=>'3',
        'dataType'=>'json',
        'select' => new yii\web\JsExpression("function( event, ui ) {setManager(ui.item.id);}")
    ],]);*/
echo "
						<div class=\"ui-widget\">
							<select id=\"selManager\" class=\"combobox\" onchange=\"setManager();\">
								<option value=\"\">Выберите пользователя</option>";
$rows = (new \yii\db\Query())
    ->select(['id','full_name'])
    ->from('users')
    ->all();
foreach ($rows as $row) {
    $selectedManager = "";
    if ($model->ceo == $row['idUser']) {
        $selectedManager = 'selected';
    }
    echo "<option ".$selectedManager." value=\"".$row['idUser']."\">".$row['nameUserFull']."</option>";
}
echo "
							</select>
						</div>	
					</div>
				</div>
			</div> 
			<div>
				<div style=\"display: inline-block;width: 10em;    vertical-align: middle;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;display: inline-block;width: 10em;\"> Вид сделки</p>
				</div>
				<div class=\"addProjectInput\">";
$params = [
    'prompt' => 'Выберите тип сделки', 'class'=>'addProjectFormField'
];
echo $form->field($model, 'agreement_id',['enableLabel' => false])->dropDownList(ArrayHelper::map(\app\models\ProjectsAgreements::find()->all(), 'id', 'name'),$params);
echo "
				</div>
			</div>";
$countProps = 0;/* (new \yii\db\Query())
    ->select(['idProp'])
    ->from('tbl_projectprops')
    ->where(['temp' => "tbl_".$model->timestamp])
    ->count();*/
if ($countProps != 0) {
    $rowsProps = (new \yii\db\Query())
        ->select(['idProp', 'nameProp', 'valueProp'])
        ->from('tbl_projectprops')
        ->where(['temp' => "tbl_".$model->timestamp])
        ->all();
    foreach ($rowsProps as $rowProps) {
        echo "
					<div id=\"tbl_".$rowProps['idProp']."\">
						<div style=\"display: inline-block;width: 10em;    vertical-align: middle;\">
							<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;display: inline-block;width: 10em;\"> 
								<input style=\"border:none;\" onchange=\"saveProp(".$rowProps['idProp'].");\" type=\"text\" id=\"name_prop_".$rowProps['idProp']."\" value=\"".$rowProps['nameProp']."\">
							/p>
						</div>
						<div class=\"addProjectInput\">
							<input style=\"border:none; width: 100%;\" onchange=\"saveProp(".$rowProps['idProp'].");\" type=\"text\" id=\"value_prop_".$rowProps['idProp']."\" value=\"".$rowProps['valueProp']."\">
						</div>
						<input class=\"redbtn\" type=\"button\" onclick=\"deleteProp(".$rowProps['idProp'].");\" value=\"Удалить поле\">
					</div>";
    }
}
echo "
			<div id=\"addProps\"></div>
			<div>
				<div style=\"display: inline-block;width: 10em;    vertical-align: middle;\">
					<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;display: inline-block;width: 10em;\"> 
						<input style=\"border:none;\" type=\"text\" id=\"name_prop\" placeholder=\"Введите название свойства...\">
					</p>
				</div>
				<div class=\"addProjectInput\">
					<input style=\"border:none; width: 100%;\" type=\"text\" id=\"value_prop\" placeholder=\"Введите значение свойства...\">
				</div>
				<input class=\"redbtn\" type=\"button\" onclick=\"addPropAdd();\" value=\"Добавить поле\">
			</div>
			<div style=\"margin-bottom: 0.625em; margin-top: 1em;\">
				<p style=\"color: #2f475b;font-family: FSRAIL55;font-size: 0.875em;display: inline-block;width: 10em;\"> Описание проекта (максимум 2000 символов)</p>";
echo $form->field($model, 'description',['enableLabel' => false])->textarea(['rows' => '6', 'maxlength' => '2000', 'class'=>'addProjectFormField']);
echo"
			</div>";

echo "
			<div style=\"padding-top: 1.25em;\">
				".Html::submitButton('Создать', ['class' => 'redbtn'])."
				<a href=\"".Yii::$app->homeUrl."\"><input type=\"button\" value=\"Назад\" style=\"margin-left: 1.875em; vertical-align: top; background: #fff; cursor: pointer; border: solid 0.0625em #d03a27; width: 9.375em; border-radius: 0.3125em; height: 2.8125em; color: #2f475b; font-size: 1em; font-family: RussianRailGRegular;\"></a>
			</div>
		</div>
	</div>
	<style> textarea { border: 0.5px solid!important;}</style>";
ActiveForm::end();
?>
<script>
    function setManager () {
        id = $("#selManager :selected").val();
        $('#addprojectform-manager').val(id);
    }

    function setCEO () {
        id = $("#selCEO :selected").val();
        $('#addprojectform-ceo').val(id);
    }

    function deleteProp (id) {
        $('#tbl_'+id).html('');
        $.ajax({
            type : 'POST',
            url : "<?=yii\helpers\Url::toRoute(['site/deleteprop'])?>",
            data:{
                id: id
            },async:false,
            success : function(data){

            },
            error : function(data){
            },
        });
    }

    function saveProp (id) {
        value = $('#value_prop_'+id).val();
        name = $('#name_prop_'+id).val();
        $.ajax({
            type : 'POST',
            url : "<?=yii\helpers\Url::toRoute(['site/saveprop'])?>",
            data:{
                id: id,
                name: name,
                value: value
            },async:false,
            success : function(data){

            },
            error : function(data){
            },
        });
    }

    function addPropAdd () {
        //timestamp = 1';
        value = $('#value_prop').val();
        name = $('#name_prop').val();
        if (timestamp != '') {
            $.ajax({
                type : 'POST',
                url : "<?=yii\helpers\Url::toRoute(['site/addpropadd'])?>",
                data:{
                    timestamp: timestamp,
                    name: name,
                    value: value
                },async:false,
                success : function(data){
                    $('#addProps').append(data);
                    $('#value_prop').val('');
                    $('#name_prop').val('');
                },
                error : function(data){
                },
            });
        }
    }
</script>