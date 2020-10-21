// prepare the form when the DOM is ready 
$(document).on('ready pjax:success', function() {
    $(document).on('change', '.master_dependency', function() { //more helpful in dynamically created elements
        var element_name = $(this).attr("name");
        var element_value = $(this).find('option:selected').attr('data-depend'); //depending_on_element_val
        if (element_value == null || element_value == '') {
            var element_value = $(this).val(); //depending_on_element_val
        }
        var type_of_depending_on_element = $(this).prop('type');
        if (type_of_depending_on_element == 'checkbox') {
            if ($(this).is(':checked')) {
                element_value = 1;
            } else {
                element_value = 0;
            }
        }
        $dependent_element = $('*[data-depending-on="' + element_name + '"]');
        $dependent_element.each(function() {
            var showValue = $(this).attr("data-depending-value"); //get array of probable value
            if (showValue.startsWith("[") && showValue.endsWith("]")) {
                var depending_on_values = showValue.slice(1, -1).split(',');
                validateDependentValue($(this), element_value, depending_on_values);
            } else {
                validateDependentValue($(this), element_value, showValue);
            }
        });
    });
    $('form').on('change', ".master_options_dependency", function() {
        var element_name = $(this).attr("name");
        var element_value = $(this).val();
        $dependent_element = $('*[data-depending-on="' + element_name + '"]');
        $dependent_element.find("option").each(function() {
            var iteratingOkVal = $(this).attr("data-depending-value");
            if (iteratingOkVal == element_value || iteratingOkVal == "force_show" || $(this).attr("value") == "") {
                $(this).show();
                if ($(this).parent('select').hasClass("select2")) {
                    $(this).removeAttr("disabled");
                    $(this).parent('select').select2();
                }
            } else {
                $(this).hide();
                if ($(this).parent('select').hasClass("select2")) {
                    $(this).attr("disabled", "disabled");
                    $(this).parent('select').select2("val", "");
                    $(this).parent('select').select2();
                }
                $(this).parent('select').val("");
            }
        });
        //Select All option
        var select_all_option = $dependent_element.data('select-all-option');
        if (select_all_option == 1) {
            $dependent_element.find("option[value='all']").remove();
            $dependent_element.append('<option value="all">All</option>');
        }
    });
    //Start working with option All
    var previously;
    $(document).on('select2:selecting', '.option-all', function(evt) {
        previously = $(this).val();
    });
    $(document).on('select2:select', '.option-all', function(evt) {
        var now = $(this).val();
        if (jQuery.inArray("all", now) != -1) { //array contain all
            if (jQuery.inArray("all", previously) != -1) { //select last selected option only
                now = jQuery.grep(now, function(value) {
                    return value != 'all';
                });
                $(this).select2("val", now);
            } else { //Select All option only
                $(this).select2("val", "all");
            }
        }
    });
    //End working with option All
    // hide error on changing
    $("input,select,textarea").change(function() {
        $(this).removeClass("errorValidation");
        $(this).closest('div').removeClass('error-view');
        $(this).next(".error_message").hide();
    });
});
$(document).on('select2:select', '.many_to_many.select2', function(e) {
    var data = e.params.data;
    $button = $($(this).attr("data-button"));
    var addition_field = $(this).attr("data-additional_field");
    var old_form_url = $button.attr("data-form");
    var new_form_url = old_form_url + "&" + addition_field + "=" + data.id;
    $button.attr("data-form", new_form_url);
    $button.click();
    setTimeout(function() {
        $button.attr("data-form", old_form_url);
    }, 200);
});
$(document).on('select2:unselecting', '.many_to_many.select2', function(e) {
    var data = e.params.args.data;
    var field = $(this).attr("data-additional_field");
    $button = $($(this).attr("data-button"));
    var $target = $($button.attr("data-target"));
    $("[name='" + field + "'] option:selected[value='" + data.id + "']").closest(".m-portlet").find(".remove:first").data("confirm", "0").click();
});
$(document).on('change', 'input[type=text],input[type=password],textarea,select', function() {
    $(this).closest(".has-error").removeClass("has-error").find(".with-errors").html("");
});
$(document).on('click', ':checkbox', function() {
    $input = $(this).find('input');
    if ($(this).is(':checked')) {
        $(this).parent().find('input.hidden-checkbox').attr('name', "");
    } else {
        $(this).parent().find('input.hidden-checkbox').attr('name', $(this).attr('name'));
    }
});
$(document).on('change', 'select[data-editable=1]', function() {
    var url = $(this).attr('data-url');
    if ($(this).val() === "add new option") {
        var select = $(this);
        var select_name = $(this).attr('name');
        var text_input_name = $('option:selected', this).attr('data-externalFieldName');
        var hidden_input_name = $('option:selected', this).attr('data-externalFieldID');
        $.get(url, function(response) {
            select.val(response.id);
            select.parent().append('<div class="unit"><input type="text" name="' + text_input_name + '">' + '<input type="hidden"  name="' + hidden_input_name + '" value="' + response.id + '"/></div>');
            select.select2('destroy').remove();
        });
    }
});
$(document).on('click', '.save_form_modal_button', function() {
    $(".do_save").click();
});
$(document).on('click', '.virtual-save', function() {
    $(this).closest('.qu-portlet').find('input.do_save:last').click();
    $('.qu-portlet').removeClass('saved-clicked');
});
$(document).on('change', 'input, select', function() {
    my_form = $(this).closest('form');
    my_form.closest('.qu-portlet').find('.virtual-save i:first').removeClass('fa-check').addClass('fa-exclamation');
});

function initForms(selector = "body") {
    $(selector + ' .ajax_form').each(function() {
        var my_form = $(this);
        // initValidation(my_form);
        initAjaxform(my_form);
    });
}

function initFineUploaders($form) {
    $form.find('.uploader').each(function() {
        var uploader = $(this);
        initFineUploader(uploader);
    });
}

function initMaps($form) {
    $form.find('.map').each(function() {
        var map = $(this);
        initMap(map);
    });
}

function initMap(map) {
    var latitude = map.attr('data-latitude');
    var longitude = map.attr('data-longitude');
    var map_address = map.attr('data-map-address');
    var zoom = map.attr('data-zoom');
    map.locationpicker({
        location: {
            latitude: $("#latitude").val(),
            longitude: $("#longitude").val()
        },
        zoom: Number(zoom),
        inputBinding: {
            latitudeInput: $(latitude),
            longitudeInput: $(longitude),
            locationNameInput: $(map_address)
        },
        enableAutocomplete: true,
        markerDraggable: true,
        onchanged: function(currentLocation, radius, isMarkerDropped) {
            $(latitude).val(currentLocation.latitude);
            $(longitude).val(currentLocation.longitude);
        }
    });
}

function initFormSelects($form) {
    $form.find('select.select2').select2();
    $form.find('.initBigData').each(function() {
        $select = $(this);
        var minimumInputLength = $select.attr("data-minimumInputLength");
        var url = $select.attr("data-url");
        var input_name = $select.attr('data-inputName');
        var pre_selected_ids = $('input[name=' + input_name + ']').val();
        var multiple = $select.prop('multiple');
        if ($select.length !== 0) {
            $select.select2({
                minimumInputLength: minimumInputLength,
                multiple: multiple,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj) {
                                return {
                                    text: obj.name,
                                    id: obj.id
                                }
                            })
                        }
                    },
                    cache: true
                }
            }).select2('val', JSON.parse(pre_selected_ids));
        }
    });
    $form.find('.initTagSelect').each(function() {
        $select = $(this);
        var url = $select.attr("data-url");
        // console.log(url);
        var input_name = $select.attr('data-inputName');
        // var pre_selected_ids = $('input[name=' + input_name + ']').val();
        var multiple = $select.prop('multiple');
        if ($select.length !== 0) {
            $select.select2({
                tags: true,
                multiple: multiple,
            });
        }
    });
}
$(document).on('click', '.add_form', function() {
    appBlockUI();
    var actionButton = $(this);
    var toAppend = $(this).data('target'); //"#objectives.child.ol";
    var array = toAppend.split("-");
    var ToClass = array[0];
    var sort = $(ToClass).data('sort');
    var add_form_parent = $(this).closest('.add_form_parent');
    $.ajax({
        method: 'get',
        url: $(this).attr('data-form'),
        success: function($element) {
            $(ToClass).append($element);
            my_form = $(ToClass).find("form:last");
            $(ToClass).find(".qu-portlet:last .portlet-toggle").click();
            $('html, body').animate({
                scrollTop: my_form.offset().top - 100
            }, 500);
            initializeChildForm(my_form);
            if (sort == 1) {
                initSortable($(ToClass));
            } else {
                serializeIDs();
            }
            virtualSave(my_form, 'fa-check');
            my_form.find('.form-actions').addClass('hidden');
        },
        complete: function() {
            appUnBlockUI();
        }
    });
});
$(document).on('click', '.add_form_here', function() {
    appBlockUI();
    var li = $(this).closest('li').not('.qu-portlet__nav-item');
    var ToClass = li.closest('ol');
    var sort = ToClass.attr('data-sort');
    var add_form_parent = $(this).closest('.add_form_parent');
    var url = add_form_parent.attr('data-form');
    $.ajax({
        method: 'get',
        url: url,
        success: function($element) {
            li.before($element);
            my_form = li.prev().find("form");
            li.prev().find(".qu-portlet:last .portlet-toggle").click();
            $('html, body').animate({
                scrollTop: my_form.offset().top - 100
            }, 500);
            initializeChildForm(my_form);
            if (sort == 1) {
                initSortable(ToClass);
            } else {
                serializeIDs();
            }
            virtualSave(my_form, 'fa-check');
            my_form.find('.form-actions').addClass('hidden');
        },
        complete: function() {
            appUnBlockUI();
        }
    });
});
/*I think it isn't usable any more */
$(document).on('click', '.add', function() { // add child element to page
    appBlockUI();
    var actionButton = $(this);
    var role = $(this).data('role');
    var toAppend = $(this).data('target'); //"#objectives.child.ol";
    var array = toAppend.split("-");
    var ToClass = array[0];
    $.post($(this).data('url'), function(data) {
        $('#hidden').find('.' + role).find('select.select2').each(function() {
            $(this).select2('destroy');
        });
        $(ToClass).find(".collapse").click();
        $portlets = $(ToClass).find(".portlet");
        if ($portlets.length != 0) {
            $portlets.each(function() {
                $element = $(this).find('input[type=text],textarea,select').filter(':visible:first');
                if ($element.is("select")) {
                    caption = $(this).find('select:first option:selected').text();
                } else {
                    caption = $element.val();
                }
                if (caption == "") {
                    caption = "";
                }
                $(this).find(".caption").html(caption);
            });
        }
        var $element = $('#hidden').find('.' + role).clone();
        if (array.length > 1) {
            var obj = array[1];
            $(ToClass).children('ol').append($element);
        } else {
            $(ToClass).append($element);
        }
        $element.find('.portlet-body').css("display", 'block');
        $element.find('.' + role + '_id').last().val(data.id);
        $element.attr('data-id', data.id);
        $element.find('.remove,.delete_Question').attr('data-action', data.remove);
        $element.find('input').attr('data-count', data.id);
        $element.find('input[name^=' + role + '_id]').val(data.id);
        $dependent_elements = $element.find(".options_dependent");
        $dependent_elements.each(function() {
            var depending_on_name = $(this).attr("data-depending-on");
            $depending_on_element = $(this).parent().find("[name=" + depending_on_name + "]");
            $new_name = $depending_on_element.attr('name') + data.id;
            $depending_on_element.attr('name', $new_name);
            $(this).attr("data-depending-on", $new_name);
        });
        if (typeof addExtraActions !== "undefined") {
            // safe to use the function
            addExtraActions(data, $element, actionButton);
        }
        $('select.select2').select2();
        $element.find('.errorValidation').removeClass("errorValidation");
        $element.find(".error_message").hide();
    }).complete(function() {
        appUnBlockUI();
    });
});

function virtualSave(my_form, $has_class) {
    if (!my_form.closest('.qu-portlet').find('.has-error').length && my_form.closest('.qu-portlet').find('.virtual-save i').hasClass($has_class)) {
        my_form.closest('.qu-portlet').find('.virtual-save i:first').toggleClass('fa-exclamation fa-check');
    }
}

function initSortable($selector) {
    new Sortable($selector[0], {
        animation: 150,
        handle: '.qu-portlet__head',
        // ghostClass: 'm-portlet--success',
        store: {
            /**
             * Get the order of elements. Called once during initialization.
             * @param   {Sortable}  sortable
             * @returns {Array}
             */
            get: function(sortable) {
                // var order = localStorage.getItem(sortable.options.group.name);
                var ordered_ids = sortable.toArray();
                serializeSortData(ordered_ids, $selector[0]);
                // return order ? order.split('|') : [];
            },
            /**
             * Save the order of elements. Called onEnd (when the item is dropped).
             * @param {Sortable}  sortable
             */
            set: function(sortable) {
                var ordered_ids = sortable.toArray();
                serializeSortData(ordered_ids, $selector[0]);
                // localStorage.setItem(sortable.options.group.name, ordered_ids.join('|'));
            }
        },
        onUpdate: function() {}
    });
}

function serializeSortData($orderedIDs, $selector) {
    var serialize_input_name = $($selector).data('serialize-input-name');
    var jsonString = JSON.stringify($orderedIDs, null, ' ');
    $("input[name=" + serialize_input_name + "]").val(jsonString);
}

function serializeIDs() {
    $(".drop_targets").each(function() {
        var data_array = new Array();
        var serialize_input_name = $(this).data('serialize-input-name');
        $(this).children("li").not('.qu-portlet__nav-item').each(function() {
            var item = {};
            item['id'] = $(this).data('id');
            data_array.push(item);
        });
        var jsonString = JSON.stringify(data_array);
        $("[name=" + serialize_input_name + "]").val(jsonString);
    });
}

function retrieveChildren($selector = "body") {
    $($selector).find(".retrieve-children").each(function() {
        $(this).removeClass("retrieve-children");
        var retrieve_route = $(this).data('retrieve-route');
        var toAppend = $(this).data('target'); //"#objectives.child.ol";
        retrieveView(retrieve_route, toAppend);
    });
}

function retrieveView(retrieve_route, toAppend) {
    appBlockUI();
    var array = toAppend.split("-");
    var ToClass = array[0];
    $.ajax({
        method: 'get',
        url: retrieve_route,
        success: function($elements) {
            var modules_views = $elements;
            $(ToClass).append(modules_views);
            $(ToClass).find('.call-lrgt').each(function() {
                var my_form = $(this);
                my_form.find('.form-actions').addClass('hidden');
                initializeChildForm(my_form);
                var first_input_value = my_form.find('input[type=text],textarea,select').filter(':first').val();
                $element = my_form.find('input[type=text],textarea,select').filter(':first');
                if ($element.is("select")) {
                    caption = my_form.find('select:first option:selected').text();
                } else {
                    caption = $element.val();
                }
                if (caption == "") {
                    caption = "";
                }
                if (caption !== '') {
                    my_form.closest('.qu-portlet').find('.qu-portlet__head-text').html(caption);
                }
            });
            $selector = $(ToClass);
            retrieveChildren(ToClass);
        },
        complete: function() {
            var sort = $(ToClass).data('sort');
            if (sort == 1) {
                $(".drop_targets").each(function() {
                    $sortingSelectorID = $(this).attr('id');
                    initSortable($(this));
                });
            } else {
                serializeIDs()
            }
            appUnBlockUI();
        }
    });
}

function initializeChildForm(my_form) {
    initValidation(my_form);
    initFormSelects(my_form);
    initFineUploaders(my_form);
    initAjaxform(my_form);
}

function initAjaxform($form) {
    $('.dataTables_length').parent().removeClass('col-md-6').removeClass('col-sm-6');
    //Hidden elements Dependencies
    $dependent_emements = $(".dependent");
    $dependent_emements.each(function() {
        $dependent_element = $(this);
        var depending_on_name = $dependent_element.attr("data-depending-on");
        var depending_on_value = $dependent_element.attr("data-depending-value");
        $depending_on_element = $("[name=" + depending_on_name + "]");
        $depending_on_element.addClass("master_dependency");
        depending_on_element_val = $depending_on_element.find('option:selected').attr('data-depend');
        if (depending_on_element_val == null || depending_on_element_val == '') {
            var depending_on_element_val = $depending_on_element.val();
        }
        var type_of_depending_on_element = $depending_on_element.prop('type');
        if (type_of_depending_on_element == 'checkbox') {
            if ($depending_on_element.is(':checked')) {
                depending_on_element_val = 1;
            } else {
                depending_on_element_val = 0;
            }
        }
        if (depending_on_value.startsWith("[") && depending_on_value.endsWith("]")) {
            var depending_on_values = depending_on_value.slice(1, -1).split(','); //get array of probable value
            validateDependentValue($dependent_element, depending_on_element_val, depending_on_values);
        } else {
            validateDependentValue($dependent_element, depending_on_element_val, depending_on_value);
        }
    });
    // Hidden options dependencies
    $dependent_emements = $(".options_dependent");
    $dependent_emements.each(function() {
        var depending_on_name = $(this).attr("data-depending-on");
        $depending_on_element = $("[name=" + depending_on_name + "]");
        $depending_on_element.addClass("master_options_dependency");
        var masterValue = $depending_on_element.val();
        var pair_dependency = $(this).data('pair-dependency');
        optionDependency($form, $(this), depending_on_name, pair_dependency);
    });
    var options = {
        beforeSubmit: beforeSubmit, // pre-submit callback
        success: success, // post-submit callback
        error: error,
        beforeSerialize: beforeSerialize
    };
    // bind form using 'ajaxForm'
    $form.ajaxForm(options);
    $form.find('.form-group').each(function() {
        if ($(this).find('.help-block.with-errors').length === 0) {
            $(this).append('<div class="help-block with-errors" style="display:none;"></div>');
        }
    });
    $form.find(".help-block,.error_message.error-view").hide();
    if (typeof ajaxFormAdditionalDependency !== "undefined") {
        // safe to use the function
        ajaxFormAdditionalDependency();
    }
}

function beforeSerialize($form, options) {
    // return false to cancel submit
    $form.find("ol.drop_targets").each(function() {
        var sort = $(this).data('sort');
        if (sort == 1) {
            serializeSortData();
        } else {
            serializeIDs()
        }
    });
    if ($form.attr("data-beforeSerialize") != "" && typeof $form.attr("data-beforeSerialize") != "undefined") {
        window[$form.attr("data-beforeSerialize")]($form);
    }
}
function appBlockUI(){
    $('.app-loader').removeClass('d-none');
}
function appUnBlockUI(){
    $('.app-loader').addClass('d-none');
}
// pre-submit callback
function beforeSubmit(formData, jqForm, options) {
    appBlockUI();
    // App.blockUI();
    // formData is an array; here we use $.param to convert it to a string to display it
    // but the form plugin does this for you automatically when it submits the data
    var queryString = $.param(formData);
    var formElement = jqForm[0];
    var pass = 1;
    $(".error_message").hide();
    if (jqForm.attr("data-beforeSubmit") != "" && typeof jqForm.attr("data-beforeSubmit") != "undefined") {
        window[jqForm.attr("data-beforeSubmit")](jqForm);
    }
    if (JSON.stringify(formData).includes('report')) {
        pass = 1;
    }
    formData.push({
        name: 'request_file_name',
        value: $(formElement).attr('data-request')
    });
    var multi_forms_variable_names = [];
    $(formElement).find('.drop_targets').each(function() { //foreach ol tag
        $request_input_name = $(this).attr('id');
        multi_forms_variable_names.push($request_input_name);
        eval($request_input_name + '=[]');
        $(this).find('form').each(function() { //foreach form in the ol tag
            var $request_file_name = $(this).attr('data-request');
            button_submit = false;
            $(this).closest('.qu-portlet').addClass('saved-clicked');
            subform_data = [{
                'id': $(this).closest('li').attr('data-id')
            }, {
                'class': $(this).closest('li').attr('class')
            }, {
                'request_file_name': $request_file_name
            }];
            $(this).find('input,textarea,select').each(function() {
                subform_data.push({
                    'name': $(this).attr('name'),
                    'value': $(this).val(),
                    'type': $(this).attr('type')
                });
            });
            $parent_drop_target = $(this).closest('.drop_targets');
            $parent_request_input_name = $parent_drop_target.attr('id');
            // console.log($parent_request_input_name, $request_input_name);
            if ($parent_request_input_name != $request_input_name) {
                $drop_target_index = $('.drop_targets').index($(this).closest('.drop_targets')) - 1;
                eval($parent_request_input_name + '=[]');
                if (eval($request_input_name)[$drop_target_index].find(x => x.name === $parent_request_input_name)) {
                    eval($parent_request_input_name + "=eval($request_input_name)[$drop_target_index].find(x => x.name === $parent_request_input_name ).value")
                } else {
                    eval($request_input_name)[$drop_target_index].push({
                        name: $parent_request_input_name,
                        value: []
                    });
                }
                eval($parent_request_input_name).push(subform_data);
                eval($request_input_name)[$drop_target_index].find(x => x.name === $parent_request_input_name).value = eval($parent_request_input_name);
            } else {
                eval($request_input_name).push(subform_data);
            }
        });
        formData.push({
            name: $request_input_name,
            value: JSON.stringify(Object.assign({}, eval($request_input_name)))
        }, {
            name: 'multi_forms_variable_names',
            value: JSON.stringify(multi_forms_variable_names)
        });
    });
    if (pass == 1) {
        return true;
    } else {
        return false;
    }
}
// post-submit callback
function success(responseText, statusText, xhr, $form) {
    appUnBlockUI();
    var response = responseText;
    if (response.action_chain) {
        actionChain(response, $form);
    }
    if (response.status == "error") {
        var $toast = toastr["error"](response.msg, "Sorry");
        viewErrors(response.forms_errors, $form);
    }
}

function viewErrors(forms_errors, $form) {
    var campos_error = [];
    $form.find('.form-group').each(function() {
        $(this).removeClass('has-error');
        $(this).addClass('has-success');
        $(this).find('.help-block').html('');
        $(this).find('.help-block').hide();
    });
    campos_error = addErrorsToForms(forms_errors, $form, campos_error);
    /* $form.closest('.qu-portlet').removeClass('saved-clicked');

    $('html, body').animate({
        scrollTop: $form.parents(".qu-portlet").find('.has-error:first').offset().top - 100
    }, 500);
    $form.parents(".qu-portlet").find('.has-error:first').find('input[type=text],textarea,select').filter(':visible:first').focus(); */
    $form.closest('.qu-portlet').removeClass('saved-clicked');
    if ($form.closest("#wizard").length > 0) {
        //alert("here");
        $error_tab = $form.find('.has-error:first').closest(".tab-pane");
        tab_index = $error_tab.prevAll().length;
        tab_index = Number(tab_index) + 1;
        console.log($('#wizard-ul li:nth-child(' + tab_index + ') a'));
        $('#wizard-ul li:nth-child(' + tab_index + ') a').click();
    }
    if ($form.parents(".qu-portlet").find('.has-error:first').length > 0) {
        $('html, body').animate({
            scrollTop: $form.parents(".qu-portlet").find('.has-error:first').offset().top - 100
        }, 500);
        $form.parents(".qu-portlet").find('.has-error:first').find('input[type=text],textarea,select').filter(':visible:first').focus();
    } else {
        $('html, body').animate({
            scrollTop: $form.find('.has-error:first').offset().top - 100
        }, 500);
        $form.find('.has-error:first').find('input[type=text],textarea,select').filter(':visible:first').focus();
    }
    formFields = $form.serializeArray();
    for (var i = 0; i < formFields.length; i++) {
        item = formFields[i];
        if (item.name.includes("[]")) {
            formFields.splice(i, 1);
            i--;
        }
    }
    $form.removeClass('has-error');
    $.each(formFields, function(i, field) {
        if ($.inArray(field.name, campos_error) === -1) {
            var father = $form.find('#' + field.name).parent('.form-group');
            // console.log(father)
            father.removeClass('has-error');
            father.addClass('has-success');
            father.find('.help-block').html('');
            father.find('.help-block').hide();
        }
    });
    $form.find(".qu-portlet").each(function() {
        if ($(this).hasClass('close-portlet')) {
            $(this).find('.portlet-toggle:first').click();
        }
    });
}

function addErrorsToForms(forms_errors, $form, campos_error) {
    if (typeof forms_errors.status !== "undefined" && forms_errors.status == "error") {
        campos_error = addErrorsToForm(forms_errors, $form, campos_error);
    }
    $.each(forms_errors, function(key, data) {
        if (typeof data.status !== "undefined" && data.status == "error") {
            campos_error = addErrorsToForm(data, $form, campos_error);
        }
        if (typeof data == "object" && typeof data.status === "undefined") {
            campos_error = addErrorsToForms(data, $form, campos_error)
        }
    });
    return campos_error;
}

function addErrorsToForm(data, $form, campos_error = []) {
    if (data.status == 'error') {
        $errors = data.errors;
        if (typeof data.class == "undefined") {
            $form_with_errors = $form;
        } else {
            $form_portlet = $('.' + data.class + '[data-id=' + data.id + ']');
            $form_with_errors = $form_portlet.find('form:first');
        }
        $.each($errors, function(key, data) {
            var pattern = /#/;
            var exists = pattern.test(key);
            if (exists) {
                var campo = $form_with_errors.find(key);
            } else if (key.indexOf('.') >= 0) {
                field_name = key.split('.')[0];
                var campo = $form_with_errors.find('[name^=' + field_name + ']');
            } else {
                var campo = $form_with_errors.find('[name=' + key + ']');
                if (campo.length == 0) {
                    var campo = $form_with_errors.find('#' + key);
                }
            }
            if (data[1]) {
                if (data[1].action_chain) {
                    actionChain(data[1]);
                }
            }
            var father = campo.closest('.form-group');
            father.removeClass('has-success');
            father.addClass('has-error');
            father.find('.help-block,.error_message.error-view').show();
            console.log(father.find('.help-block'));
            father.find('.help-block').html(data[0]);
            campos_error.push(key);
        });
    }
    return campos_error;
}

function error(responseText, statusText, xhr, $form) {
    appUnBlockUI();
    var $toast = toastr["error"](responseText, statusText);
}

function optionDependency($form, $dependent_elements, depending_on_name, pair_dependency = 1) {
    if (pair_dependency == 1) {
        $depending_on_element = $dependent_elements.closest('form').find("[name=" + depending_on_name + "]");
    } else {
        $depending_on_element = $("[name=" + depending_on_name + "]");
    }
    var masterValue = $depending_on_element.val();
    $dependent_elements.find("option").each(function() {
        var iteratingOkVal = $(this).attr("data-depending-value");
        var selectedValue = $(this).parent('select').val();
        if (iteratingOkVal == masterValue || iteratingOkVal == "force_show" || $(this).attr("value") == "" || $(this).attr("value") == "all" //<option value="all">
        ) {
            $(this).show();
            if ($(this).parent('select').hasClass("select2")) {
                $(this).removeAttr("disabled");
                $(this).parent('select').select2();
            }
        } else {
            $(this).hide();
            if ($(this).parent('select').hasClass("select2")) {
                $(this).attr("disabled", "disabled");
                $(this).parent('select').select2();
            }
            if (selectedValue == $(this).attr("value")) {
                $(this).parent('select').val("");
            }
        }
    });
}

function validateDependentValue($element, $depending_on_element_val, depending_on_value) {
    if (!depending_on_value.includes($depending_on_element_val)) { //In Array Dependency
        $element.find("input,select").change();
        $element.find("input,select").hide();
        $element.hide(250);
    } else {
        $element.find("input,select").show();
        $element.show(250);
    }
}
$(document).on('click', '.filepicker', function() {
    var target = $(this).data('target');
    $(this).closest('.form-group').find('.fileinput').click();
});
$(document).on('change', '.fileinput', function() {
    $('#save-all').prop('disabled', true);
    var $container = $(this).closest('.form-group');
    $container.find('.filepicker').addClass('hidden');
    $container.find('.filenameplaceholder').addClass('hidden');
    var $progressBar = $container.find('.progress-bar');
    $progressBar.removeClass('hidden').find('span').removeClass('hidden');
    $container.find('.cancel').removeClass('hidden');
    var data = new FormData();
    var $file = $(this);
    var url = $file.data('action');
    data.append('file', $file[0].files[0]);
    $.ajax({
        method: 'post',
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function(xhr) {
            $file.val("");
            $container.find('.cancel').click(function() {
                xhr.abort();
                $container.find('.cancel').addClass('hidden');
                $container.find('.filepicker').removeClass('hidden');
                $container.find('.filenameplaceholder').removeClass('hidden');
                $progressBar.addClass('hidden');
                $progressBar.width(0);
            })
        },
        xhr: function() {
            // get the native XmlHttpRequest object
            var xhr = $.ajaxSettings.xhr();
            // set the onprogress event handler
            xhr.upload.onprogress = function(evt) {
                var percent = Math.ceil(evt.loaded / evt.total * 100);
                $progressBar.width(percent + '%');
                $progressBar.find('span').html(percent + '%');
            };
            // return the customized object
            return xhr;
        },
        success: function(data) {
            $progressBar.width(0);
            $progressBar.addClass('hidden');
            $container.find('.cancel').addClass('hidden');
            //Download photo action
            link = document.createElement('a');
            link.href = data.download_action;
            link.innerHTML = data.file_name;
            $container.find('.filenameplaceholder ').html(link).removeClass('hidden');
            //Delete photo action
            $container.find('.removefile').attr('data-action', data.remove_action).removeClass('hidden');
            //Show photo action
            $('.show').find('img').attr('src', data.show_action)
            link = document.createElement('img');
            link.setAttribute('class', 'img-thumbnail');
            link.src = data.show_action;
            link.innerHTML = data.file_name;
            $container.find('.show ').html(link).removeClass('hidden');
        },
        complete: function() {
            $('#save-all').prop('disabled', false);
        }
    });
});
$(document).on('click', '.removefile', function(e) {
    appBlockUI();
    var $btn = $(this);
    var $container = $(this).closest('.form-group');
    e.preventDefault();
    $.ajax({
        method: 'delete',
        url: $(this).data('action'),
        success: function() {
            if ($btn.attr("data-deleteFileSuccess") != "" && typeof $btn.attr("data-deleteFileSuccess") != "undefined") {
                window[$btn.attr("data-deleteFileSuccess")]($btn);
            }
            $container.find('.filenameplaceholder').html('');
            /*No file selected*/
            $container.find('.removefile').addClass('hidden');
            $container.find('.filepicker').removeClass('hidden');
        },
        complete: function() {
            appUnBlockUI();
        }
    });
});
function actionChain(response, $selector = $("body")) {
    var actions = response.action_chain;
    $.each(actions, function(action_name, value) {
        if (action_name == "toastr") {
            toastrOptions = value;
            $.toast({
                    heading: toastrOptions['title'],
                    text: toastrOptions['msg'],
                    icon: toastrOptions['type'],
                    position: 'top-right',
                })
        }
        if (action_name == "swal") {
            swalOptions = value;
            swal(swalOptions['title'], swalOptions['msg']);
            setTimeout(function() {
                $('.mfp-close', window.parent.document).click();
            });
            $('.sweet-alert').addClass(swalOptions['className'])
        }
        if (action_name == "Run function") {
            window[value](response);
        }
        if (action_name == "Click") {
            $(value).click();
        }
        if (action_name == "alert-msg") {
            setTimeout(function() {
                alertOptions = value;
                $('.qu-alert').html(alertOptions['msg']);
                $('.qu-alert').addClass(alertOptions['type']).removeClass('hidden');
                $('.qu-alert').delay(2000).fadeOut();
            }, 800);
        }
        if (action_name == "Run function") {
            window[value](response);
        }
        // Animate to div
        if (action_name == "Anchor") {
            anchor_to = value;
            $('html, body').animate({
                scrollTop: $(anchor_to).offset().top - 100
            }, 500);
        }
        if (action_name == "Validation Messages") {
            parameters = value;
            $.each(parameters, function(selector, message) {
                validationMessages(selector, message);
            })
        }
        if (action_name == "Refresh Server Side DataTable") {
            selector = value;
            $(selector).DataTable().draw();
        }
        if (action_name == "page") {
            if (value != "none") {
                virtualSave($selector, 'fa-exclamation');
                if (value == "without_pjax") {
                    withourPjaxUrl = actions['page_url'];
                    window.location.href = withourPjaxUrl;
                    return false;
                }
                if (value == "reload") {
                    location.reload();
                    return false;
                }
                url = value;
                pjaxPage(url);
                $(".close_modal").click();
                $(".close_modal").click();
                reloadFn = actions['reloadFn'];
                if (typeof window[reloadFn] !== "undefined") {
                    location.reload();
                    return false;
                }
            }
            url = value;
            
        } else {
            $(".resetForm").click();
            $(".close_modal").click();
            $(".close_modal").click();
        }
    });
}
/* to be revised*/
function customFileInput($elements) {
    $elements.each(function(index, el) {
        var data = {
            id: $(el).closest('.level').find('input[name=id]').val()
        };
        var url = $(el).data('delete');
        $(el).fileinput({
            uploadUrl: $(el).data('action'),
            showPreview: false,
            uploadExtraData: function(previewId, index) {
                return data;
            },
            allowedPreviewTypes: ['image'],
            initialPreviewConfig: [{
                caption: 'desert.jpg',
                width: '120px',
                url: url, // server delete action
                key: 100,
                extra: {
                    id: 100
                }
            }]
        });
        $(el).on('fileclear', function() {});
        $(el).on('fileloaded', function(event, file, previewId, index, reader) {});
        $(el).on('filedeleted', function(event, key) {});
    });
}

function initTinyMces(selector = "body") {
    $(selector + " .tinymce").each(function() {
        console.log($(this));
        var id = $(this).attr("id");
        var selector = "#" + id;
        destroyTinyMce(selector);
        initTinyMce(selector);
    });
}

function initTinyMce(selector) {
    height = 500;
    $textfield = $(selector);
    if ($textfield.attr('data-height') != "") {
        height = $textfield.attr('data-height');
    }
    tinymce.init({
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        selector: selector,
        height: height,
        theme: 'modern',
        toolbar: "save",
        inline_styles: true,
        plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
}

function destroyTinyMce(selector) {
    tinymce.remove(selector);
}
$(document).on('change', '.toggle_field', function(e) {
    var $checkbox = $(this);
    $checkbox.prop('disabled', true);
    var selector = $(this).attr('data-selector');
    var checked_value = $(this).attr('data-checked-value');
    var unchecked_value = $(this).attr('data-unchecked-value');
    if ($checkbox.is(':checked')) {
        $(selector).val(checked_value).change();
    } else {
        $(selector).val(unchecked_value).change();
    }
    $checkbox.prop('disabled', false);
});

function initTinyMces(selector = "body") {
    $(selector + " .tinymce").each(function() {
        console.log($(this));
        var id = $(this).attr("id");
        var selector = "#" + id;
        destroyTinyMce(selector);
        initTinyMce(selector);
    });
}

function initTinyMces(selector = "body") {
    $(selector + " .tinymce").each(function() {
        console.log($(this));
        var id = $(this).attr("id");
        var selector = "#" + id;
        destroyTinyMce(selector);
        initTinyMce(selector);
    });
}

function initTinyMce(selector) {
    height = 500;
    $textfield = $(selector);
    if ($textfield.attr('data-height') != "") {
        height = $textfield.attr('data-height');
    }
    tinymce.init({
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        selector: selector,
        height: height,
        theme: 'modern',
        toolbar: "save",
        inline_styles: true,
        plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
}

function destroyTinyMce(selector) {
    tinymce.remove(selector);
}
$(document).on('change', '.toggle_field', function(e) {
    var $checkbox = $(this);
    $checkbox.prop('disabled', true);
    var selector = $(this).attr('data-selector');
    var checked_value = $(this).attr('data-checked-value');
    var unchecked_value = $(this).attr('data-unchecked-value');
    if ($checkbox.is(':checked')) {
        $(selector).val(checked_value).change();
    } else {
        $(selector).val(unchecked_value).change();
    }
    $checkbox.prop('disabled', false);
});

function initTinyMce(selector) {
    height = 500;
    $textfield = $(selector);
    if ($textfield.attr('data-height') != "") {
        height = $textfield.attr('data-height');
    }
    tinymce.init({
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        selector: selector,
        height: height,
        theme: 'modern',
        toolbar: "save",
        inline_styles: true,
        plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
}

function destroyTinyMce(selector) {
    tinymce.remove(selector);
}
$(document).on('change', '.toggle_field', function(e) {
    var $checkbox = $(this);
    $checkbox.prop('disabled', true);
    var selector = $(this).attr('data-selector');
    var checked_value = $(this).attr('data-checked-value');
    var unchecked_value = $(this).attr('data-unchecked-value');
    if ($checkbox.is(':checked')) {
        $(selector).val(checked_value).change();
    } else {
        $(selector).val(unchecked_value).change();
    }
    $checkbox.prop('disabled', false);
});

function initTinyMce(selector) {
    height = 500;
    $textfield = $(selector);
    if ($textfield.attr('data-height') != "") {
        height = $textfield.attr('data-height');
    }
    tinymce.init({
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        selector: selector,
        height: height,
        theme: 'modern',
        toolbar: "save",
        inline_styles: true,
        plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
}

function destroyTinyMce(selector) {
    tinymce.remove(selector);
}
$(document).on('change', '.toggle_field', function(e) {
    var $checkbox = $(this);
    $checkbox.prop('disabled', true);
    var selector = $(this).attr('data-selector');
    var checked_value = $(this).attr('data-checked-value');
    var unchecked_value = $(this).attr('data-unchecked-value');
    if ($checkbox.is(':checked')) {
        $(selector).val(checked_value).change();
    } else {
        $(selector).val(unchecked_value).change();
    }
    $checkbox.prop('disabled', false);
});