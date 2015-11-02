<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Param;
use yii\widgets\ActiveForm;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form ActiveForm */

$this->registerJsFile('https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key='.Param::getParamValue('google:apiKey'), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/register_member.js', [
    'depends' => [\yii\web\JqueryAsset::className()],
    'position' => \yii\web\View::POS_END]
);
?>

<div class="register-registerAsMember">

    <?php $form = ActiveForm::begin([
        'id' => 'registrationAsMember-form',
    ]); ?>
    
    <?= $form->field($model, 'USER_NICKNAME') ?>
    
    <?= $form->field($model, 'USER_LASTNAME') ?>
    
    <?= $form->field($model, 'USER_FORNAME') ?>
    
    <div class="form-group">
        <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text" class="form-control"></input>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-xs-2">
                <label class="control-label" for="street_number">Street address</label>
            </div>
            <div class="col-xs-3">
                <input class="form-control" id="street_number" disabled="true"></input>
            </div>
            <div class="col-xs-7">
                <input class="form-control" id="route" disabled="true"></input>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-2">
                <label class="control-label" for="locality">City</label>
            </div>
            <div class="col-xs-10">
                <input class="form-control" id="locality" disabled="true"></input>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-2">
                <label class="control-label" for="administrative_area_level_1">State</label>
            </div>
            <div class="col-xs-2">
                <input class="form-control" id="administrative_area_level_1" disabled="true"></input>
            </div>
            <div class="col-xs-2">
                <input class="form-control" id="administrative_area_level_2" disabled="true"></input>
            </div>
            <div class="col-xs-2">
                <label class="control-label" for="postal_code">Zip code</label>
            </div>
            <div class="col-xs-4">
                <input class="form-control" id="postal_code" disabled="true"></input>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-2">
                <label class="control-label" for="country">Country</label>
            </div>
            <div class="col-xs-10">
                <input class="form-control" id="country" disabled="true"></input>
            </div>
        </div>
    </div>
       
    <?= $form->field($model, 'USER_ADDRESS')->textarea() ?>
    
    <?= Html::activeHiddenInput($model, 'USER_LATITUDE'); ?>
    
    <?= Html::activeHiddenInput($model, 'USER_LONGITUDE'); ?>
    
    <?= $form->field($model, 'COUNTRY_COUNTRY_ID')->dropDownList(Country::getCountriesList(),[
        'prompt' => '- Choose your Country -'
        ]);
    ?>
    
    <?= $form->field($model, 'USER_PHONE') ?>

    <?= $form->field($model, 'USER_MAIL') ?>
    
    <?= $form->field($model, 'USER_MAIL_PROJECT') ?>

    <?= $form->field($model, 'USER_PASSWORD_VERIFY')->passwordInput() ?>    
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app/user', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- register-registerAsMember -->
