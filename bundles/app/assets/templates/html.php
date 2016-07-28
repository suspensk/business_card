<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="/bundles/app/bootstrap.min.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Stint+Ultra+Condensed' rel='stylesheet' type='text/css'>
    <link href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/bundles/app/datepicker/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/bundles/app/bootstrap-select-master/css/bootstrap-select.min.css">
<style>

    .glyphicon-refresh-animate {
        -animation: spin .7s infinite linear;
        -ms-animation: spin .7s infinite linear;
        -webkit-animation: spinw .7s infinite linear;
        -moz-animation: spinm .7s infinite linear;
    }

    @keyframes spin {
        from { transform: scale(1) rotate(0deg);}
        to { transform: scale(1) rotate(360deg);}
    }

    @-webkit-keyframes spinw {
        from { -webkit-transform: rotate(0deg);}
        to { -webkit-transform: rotate(360deg);}
    }

    @-moz-keyframes spinm {
        from { -moz-transform: rotate(0deg);}
        to { -moz-transform: rotate(360deg);}
    }
    .bootstrap-select.btn-group.changeEntity{margin-bottom: 0; width: 100%;}
    .buttons-container{text-align:right;}
    #multi_pages_ul a {color:#FFFFFF;}
    .list-container {width:90%}
    #campaignForm .section-title {margin: 40px 0 40px 0;}
    #campaignForm .section-title:first-of-type {margin-top: 0;}
    #multi_pages_ul li:first-child {font-size: 1.1em; font-weight: bold;}
    #multi_pages_ul .buttons-container {margin-bottom:2px;}
    #multi_pages_ul .landing-page {overflow: auto}
    #campaignForm .save-btn {width:150px;}

</style>
</head>
<body>

<?php $this->childContent(); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/tabletools/2.2.3/js/dataTables.tableTools.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="/bundles/app/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/bundles/app/bootstrap-validator-master/js/validator.js"></script>
<script src="/bundles/app/bootstrap-select-master/js/bootstrap-select.min.js"></script>
<script src="/bundles/app/bootstrap-notify-master/bootstrap-notify.min.js"></script>
<script src="/bundles/app/bootbox-master/bootbox.js"></script>
<script src="/bundles/app/zclip/jquery.zclip.min.js"></script>
<script>
    $(document).ready(function() {
        $('#campTbl').DataTable({
            paging: true,
            ordering: true,
            "lengthMenu": [[-1, 25, 50, 100], ["All", 25, 50, 100]]
        });

        $('.selectpicker').selectpicker({
            style: 'btn-primary',
            size: 10
        });

        $(function() {
            $.fn.datepicker.defaults.autoclose = true;
            $.fn.datepicker.defaults.format = "yyyy-mm-dd";
        });
        init_zclip();

        $('#countries').on('change', function () {
        //    $(this).data('default',$(this).val());
        /*    if($(this).val() != ''){
                $('#citiesBtnAdd').removeAttr('disabled');
            } else{
                $('#citiesBtnAdd').attr('disabled', true);
            }*/
            activateCitiesButtons();
            get_cities($(this).val(),'');
        });

        $('#multi_pages').on('change', function () {

            var defaultPage =$('#pages').find('option:selected');
            $('#pages').find('option[value!=""]').remove();
            var landing_pages = $('#multi_pages').find('option:selected');
            var selectedData = []; // to remember what was selected after reloading list
            $.each(landing_pages, function(i, el)
            {
                selectedData.push(el.value);
                var selected = false;

                if(el.value == defaultPage.val()){
                    selected = true;
                }
                $('#pages').append( new Option(el.text,el.value, false, selected));
            });
            $('#pages').selectpicker('refresh');
            $('#multi_pages').data('default', selectedData.join(','));
        });

        $('.changeEntity').on('change', function () {
          if($(this).val() == ""){
              $(this).parents('.form-group').find('.openEditForm').attr('disabled',true);
              $(this).parents('.form-group').find('.deleteEntity').attr('disabled',true);
          } else{
              $(this).parents('.form-group').find('.openEditForm').removeAttr('disabled');
              $(this).parents('.form-group').find('.deleteEntity').removeAttr('disabled');
          }
        })
        /*$('input').attr('readonly',true);
        $('textarea').attr('readonly',true);
        $('select').attr('disabled',true);
        $('.date input').attr('disabled',true);
        $('button').attr('disabled',true);*/
    });

    $('.modalForm').on('shown.bs.modal', function () {
      //  $('#' + $(this).attr('id') + 'Form').validator();
        $( "input[name=name]" ).focus();
        $(this).find('form').validator();
    })
    $(".modalForm").on("hidden.bs.modal", function () {
        $(this).find('.result').removeClass('alert alert-success alert-danger').html('');
        $(this).find('.form-group').removeClass('has-error has-danger');
        $(this).find("input[name]").val('');
        $(this).find('.help-block').html();

     //   $('#' + $(this).attr('id') + 'Form').validator();
    });

    $('.deleteEntity').on('click', function () {
        bootbox.dialog({
            message: "Are you sure want to delete the entity? This entity will be deleted RIGHT NOW from the DATABASE and from ALL of the campaigns that use it!",
            title: "Important!",
            buttons: {
                danger: {
                    label: "No, don't DELETE",
                    className: "btn-success",
                    callback: function() {
                        return 0;
                    }
                },
                success: {
                    label: "Yes, DELETE",
                    className: "btn-danger",
                    callback: function() {
                        deleteFunc();
                    }
                }

            }
        });
        var btn = $(this);
        var deleteFunc = function(){
            btn.parents('.form-group').find('.openEditForm').attr('disabled', true);
            btn.attr('disabled', true);
            var type = btn.data('type');
            var types = btn.data('types');
            var action = 'delete';
            var entityId = btn.parents('.form-group').find('select').val();
            var data = {id: entityId};
            $.ajax({
                type: 'post',
                url: '/campaigns/' + action + '_' + type,
                data: data,
                success: function (response) {

                    var serverResult = jQuery.parseJSON(response);

                    if(serverResult.result == 0){
                        //   resultBlock.addClass('alert alert-success').html('Data saved successfully');
                        if(type == 'city' || type == 'country'){
                            get_cities($('#countries').val(),'');
                        }
                        if(type != 'city')
                        {
                            get_entities(types, '');
                        }
                        $.notify({
                            // options
                            message: 'Data deleted successfully!'
                        },{
                            // settings
                            type: 'success'
                        });

                    } else{
                        var errMess = "<p>Data was not saved!</p>";
                        $.each(serverResult.errors, function(i, el)
                        {
                            errMess+= "<p>"+ el +"</p>";
                        });
                        $.notify({
                            // options
                            message: errMess
                        },{
                            // settings
                            type: 'danger'
                        });
                        //    resultBlock.addClass('alert alert-danger').html('Data was not saved!');
                    }


                }
            });
        }
    });

    $('.openAddForm').on('click', function () {
        var target = $(this).data('target');
        var id = target.substr(1);
        $('.modalFormSimple').attr('id', id);
        var type = $(this).data('type');
        var types = $(this).data('types');
      //  $('#' + id).find('#addEntityForm').data('type',type).data('types',types);
        $('#addEntityForm').data('type',type).data('types',types);
        if(type == 'city'){
            $('#addEntityForm').find('input[name=country]').val($('#countries').val());
         //   $('#countryName').html($('#countries').find('option:selected').text());
        }
        if($(this).hasClass('openEditForm')){
            $('#addEntityForm').find('input[name=id]').val($(this).parents('.form-group').find('select').val());
            $('#addEntityForm').find('input[name=name]').val($(this).parents('.form-group').find('select').find('option:selected').text())
        }{

        }
    });

    $("#saveAsNew").on('click', function () {
        $(this).addClass('activated')
        $( "#campaignForm" ).submit();
    });

    $('#campaignForm').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function init_zclip(){
        var str = '';
        var pages = $('.landing-page');
        var len = pages.length;
        $.each(pages, function(i, el)
        {
            str += $(this).html();
            if(i != len - 1){
                str += "\r\n";
            }
        });
        $('#copyAll').zclip({
            path:'/bundles/app/zclip/ZeroClipboard.swf',
            copy: function(){
                return  str;
            }
        });

        $('.copyButton').zclip({
            path:'/bundles/app/zclip/ZeroClipboard.swf',
            copy: function(){
                return  $(this).parents('.multi_pages_ul').find('.landing-page').html();
            }
        });
    }

    function activateCitiesButtons(){
        if($('#countries').val() != ''){
            $('#citiesBtnAdd').removeAttr('disabled');
            if($('#cities').val() != ''){
                $('#citiesBtnEdit').removeAttr('disabled');
                $('#citiesBtnRemove').removeAttr('disabled');
            }
        } else{
            $('#citiesBtnAdd').attr('disabled', true);
            $('#citiesBtnEdit').attr('disabled', true);
            $('#citiesBtnRemove').attr('disabled', true);
        }

    }

    $( "#campaignForm" ).submit(function( event ) {
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var asNewButton = $("#saveAsNew");
        var action = 'add';
        var typeAction = 'simple';

        if(submitButton.hasClass('disabled') || submitButton.attr('disabled') == 'disabled'){
            if(asNewButton.hasClass('activated')){
                asNewButton.removeClass('activated');
            }
            return false;
        }

        submitButton.attr('disabled',true);
        asNewButton.attr('disabled',true);
        form.find('.result').removeClass('alert alert-success alert-danger').html('');
        var data = {data: form.serialize()};
        var entityId = form.find("input[name='id']").val();
        if(entityId && entityId != 0){
            action = 'edit';
        }
        if(asNewButton.hasClass('activated')){
            action = 'add';
            typeAction = 'clone';
            asNewButton.removeClass('activated').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Saving as New');
        }

        if(typeAction == 'simple'){
            submitButton.html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Saving');
        }

        $.ajax({
            type: 'post',
            url: '/campaigns/' + action,
            data: data,
            success: function (response) {
                var serverResult = jQuery.parseJSON(response);
                var resultBlock = form.find('.result');
                if(serverResult.result == 0 && serverResult.id != 0){
                //    resultBlock.addClass('alert alert-success').html('Data saved successfully');
                    $.notify({
                        // options
                        message: 'Data '+action+'ed successfully!'
                    },{
                        // settings
                        type: 'success'
                    });
                    if(action == 'add'){
                            window.location.href = '/campaigns/view/' + serverResult.id;
                    } else{
                        submitButton.removeAttr('disabled').html('Save');
                        asNewButton.removeAttr('disabled').html('Save as New');
                        get_campaign_pages(entityId);
                    }

                } else{
                    submitButton.removeAttr('disabled').html('Save');
                    asNewButton.removeAttr('disabled').html('Save as New');
                 //   resultBlock.addClass('alert alert-danger').html('Data was not saved!');
                    errMess = '<p>Data was not saved!</p>';
                    $.each(serverResult.errors, function(i, el)
                    {
                        errMess += "<p>"+ el +"</p>";
                    });
                    $.notify({
                        // options
                        message: errMess
                    },{
                        // settings
                        type: 'danger'
                    });
                }
            }
        });
        event.preventDefault();
    });


    $( ".addEntityForm" ).submit(function( event ) {
        var type = $(this).data('type');
        var types = $(this).data('types');
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var action = 'add';
        if(submitButton.hasClass('disabled')){
            return false;
        }

        submitButton.attr('disabled', true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Saving');
        form.find('.result').removeClass('alert alert-success alert-danger').html('');

        var name = form.find("input[name='name']").val();
        var data = {name: name};
     //   data.name = name;
        if(type == 'city'){
            var country = form.find("input[name='country']").val();
            data.country = country;
        }
        var entityId = form.find("input[name='id']").val();
        if(entityId != 0){
            action = 'edit';
            data.id = entityId;
        }

        $.ajax({
            type: 'post',
            url: '/campaigns/' + action + '_' + type,
            data: data,
            success: function (response) {
                submitButton.removeAttr('disabled').html('Save');
                var serverResult = jQuery.parseJSON(response);
                var resultBlock = form.find('.result');
                if(serverResult.result == 0){
                    if(action == 'add'){
                        entityId = serverResult.id
                    }
                    resultBlock.addClass('alert alert-success').html('Data saved successfully');
                    if(type == 'city'){
                        get_cities(country, entityId);
                    } else{
                        get_entities(types, entityId);
                        if(type == 'country' && action == 'add'){
                          //  get_cities(entityId,'');
                            $('#cities').find('option[value!=""]').remove();
                            $('#cities').selectpicker('refresh');
                            // $('#citiesBtnEdit').attr('disabled', true);
                            // $('#citiesBtnRemove').attr('disabled', true);
                            activateCitiesButtons();

                        }
                    }

                    setTimeout(function(){
                        form.parents().find('.modalForm').modal('hide');
                    }, 1000);
                } else{
                    resultBlock.addClass('alert alert-danger').html('Data was not saved!');
                    $.each(serverResult.errors, function(i, el)
                    {
                        resultBlock.append( "<p>"+ el +"</p>" );
                    });
                }
            }
        });
        event.preventDefault();
    });

    function get_cities(val, entityId)
    {
        if(val!=''){
            $('#citiesBtnAdd').attr('disabled',true).removeClass('glyphicon-plus').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
            $('#cities').parents('.form-group').find('.bootstrap-select > button').addClass('disabled');
            $.ajax({
                type: 'post',
                url: '/campaigns/get_cities',
                data: {
                    country:val
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $('#cities').find('option[value!=""]').remove();
                    $.each(result, function(i, el)
                    {
                        var selected = false
                        if(el.id == entityId) {
                            selected = true;
                        //    $('#citiesBtnEdit').removeAttr('disabled');
                        //    $('#citiesBtnRemove').removeAttr('disabled');
                        }
                        $('#cities').append( new Option(el.name,el.id, false, selected));
                    });

                    $('#cities').parents('.form-group').find('.bootstrap-select > button').removeClass('disabled');
                    $('#citiesBtnAdd').html('').removeAttr('disabled').addClass('glyphicon-plus');
                    $('#cities').selectpicker('refresh');
                    activateCitiesButtons();
                }
            });
        } else{
            $('#cities').find('option[value!=""]').remove();
            $('#cities').selectpicker('refresh');
        }


    }

    function get_campaign_pages(val)
    {
        var defaultPage = $('#pages').find('option:selected')
        $('#multi_pages_ul').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
            $.ajax({
                type: 'post',
                url: '/campaigns/get_campaign_pages',
                data: {
                    campaign:val,
                    default:defaultPage.val()
                },
                success: function (response) {
                    $('#multi_pages_ul').html(response);
                    init_zclip();
                }
            });
    }

    function get_entities(types, entityId)
    {
        $('#' + types + 'BtnAdd').removeClass('glyphicon-plus').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
            $.ajax({
                type: 'post',
                url: '/campaigns/get_' + types,
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $('#' + types).find('option[value!=""]').remove();

                //    var campaignData = $('#' + types).data('default');
                    $.each(result, function(i, el)
                    {
                        var selected = false;

                        if(el.id == entityId){
                            selected = true;
                            $('#' + types).parents('.form-group').find('.openEditForm').removeAttr('disabled');
                            $('#' + types).parents('.form-group').find('.deleteEntity').removeAttr('disabled');
                        }

                        $('#' + types).append( new Option(el.name,el.id, false, selected));

                    });
                    if(types == 'countries'){
                        activateCitiesButtons();
                       /* if($('#countries').val() != ''){
                            $('#citiesBtnAdd').removeAttr('disabled');
                        } else{
                            $('#citiesBtnAdd').attr('disabled',true);
                        }*/
                    }
                    $('#' + types).selectpicker('refresh');
                   $('#' + types + 'BtnAdd').addClass('glyphicon-plus').html('');

                    if(types == 'pages'){
                        $('#multi_pages').find('option[value!=""]').remove();
                        $('#pages').find('option[value!=""]').remove();
                        var defaultData  = $('#multi_pages').data('default');
                        var campaignDataP = defaultData.toString().split(",");
                        $.each(result, function(i, el)
                        {
                            var selected = false;
                            var selectedDefault = false;
// EDIT
                            if(jQuery.inArray( el.id, campaignDataP ) != -1 || el.id == entityId){
                                selected = true;
                                if(el.id == entityId){
                                    $('#multi_pages').data('default', defaultData + ',' + entityId)
                                    selectedDefault = true
                                }
                                $('#pages').append( new Option(el.url,el.id, false, selectedDefault));
                            }

                            $('#multi_pages').append( new Option(el.url,el.id, false, selected));

                        });
                        $('#multi_pages').selectpicker('refresh');
                        $('#pages').selectpicker('refresh');

                    }
                }
            });
    }

</script>
</body>
</html>