/* 
 * Copyright (C) 2015 MATYSIAK Herve <herve.matysiak@viacesi.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


$("#ajax_submit_add").click(function(event){
   event.preventDefault();
   var $form = $(this).parents("form");
   var $data = $form.serializeArray();
   $data.push({name: 'action', value: $(this).attr('name')});
   $.ajax({
       'type':'POST',
       'cache':false,
       'url': $form.attr('action'),
       'data': $data,
       'success' : function(data, textStatus, XMLHttpRequest){
           $.pjax.reload({container:'#service-crgidview'});
       }
   });
});

$("#ajax_submit_remove").click(function(event){
   event.preventDefault();
   var $form = $(this).parents("form");
   var $data = $form.serializeArray();
   $data.push({name: 'action', value: $(this).attr('name')});
   $.ajax({
       'type':'POST',
       'cache':false,
       'url': $form.attr('action'),
       'data': $data,
       'success' : function(data, textStatus, XMLHttpRequest){
           $.pjax.reload({container:'#service-crgidview'});
       }
   });
});