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
           $.pjax.reload({container:'#service-cgridview'});
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
           $.pjax.reload({container:'#service-cgridview'});
       }
   });
});