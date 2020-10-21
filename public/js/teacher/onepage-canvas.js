function replaceCopiedToTopicTag(action) {
    if ($('#bind_field').val() == 0) {
        var sel = window.getSelection();
        console.log('{{' + sel + '}}');
        var relaced_with = '';
        if (sel != '' && sel != 'undefined') {
            if (action == 'topic_tag') {
                relaced_with = '{{' + sel + '}}';
            } else if (action == 'key_phrase') {
                relaced_with = sel;
                var t = sel;
                t = t.toString();
                t = t.replace(/[^\w\s]/gi, '');
                search_google = true;
                window.open('https://www.google.com/search?&q="' + t + '"');
                return;
            } else {
                var t = sel.toString();
                if (t.split(" ").length > 1) {
                    relaced_with = '{' + sel + '}';
					relaced_with = relaced_with.replace("\n", "", "g")
                } else {
                    relaced_with = '{' + sel + '}';
                }				
            }
            replaceSelectedText(relaced_with, sel);
        }
    } else {
        $('#alert-preview-mode').modal('show');
        //alert('You are in review mode');
    }
}

function replaceSelectedText(replacementText) {
    var sel, range;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            range.insertNode(document.createTextNode(
                replacementText));
        }
    } else if (document.selection && document.selection
        .createRange) {
        range = document.selection.createRange();
        range.text = replacementText;
    }
	var str = jQuery('#editor_textarea').html();
	str = str.replace('<div></div>'+replacementText+'', '<div>'+replacementText+'</div>');
	str = str.replace(' }', '}');
	jQuery('#editor_textarea').html(str);
}

function replaceCopiedText() {
    if ($('#bind_field').val() == 0) {
        var str = $('#editor_textarea').html();
        console.log(str);

        var regex = new RegExp('<div>', 'g');
        str = str.replace(regex, 'BOFDIV');

        var regex2 = new RegExp('</div>', 'g');
        str = str.replace(regex2, 'EOFDIV');
        //alert(str);
        var regex2 = new RegExp('<br>', 'g');
        str = str.replace(regex2, 'BOFBR');

        var regex2 = new RegExp('</p>', 'g');
        str = str.replace(regex2, 'EOFP');

        var regex2 = new RegExp('</th>', 'g');
        str = str.replace(regex2, 'EOFTH');

        var regex2 = new RegExp('</td>', 'g');
        str = str.replace(regex2, 'EOFTD');

        var regex3 = /(<([^>]+)>)/ig
        str = str.replace(regex3, "");
        console.log(str);

        var regex4 = new RegExp('BOFDIV', 'g');
        str = str.replace(regex4, '<div>');

        var regex5 = new RegExp('EOFDIV', 'g');
        str = str.replace(regex5, '</div>');

        var regex2 = new RegExp('BOFBR', 'g');
        str = str.replace(regex2, '<br>');

        var regex2 = new RegExp('EOFP', 'g');
        str = str.replace(regex2, '</p>');

        var regex2 = new RegExp('EOFTD', 'g');
        str = str.replace(regex2, ' ');

        var regex2 = new RegExp('EOFTH', 'g');
        str = str.replace(regex2, ' ');
        console.log(str);
        $('#editor_textarea').html(str)
    } else {
        console.log(123);
        $('#alert-preview-mode').modal('show');
        return false;
    }
}

$(document).ready(function () {

    $('.arp_save_btn').click(function () {
        var arp_id = $(this).data('atr');
        var arp_text = $('#arp_id_' + arp_id).val();
        if (arp_text == '') {
            alert('Please enter value ARP cant save blank value');
            return false;
        }
        $('.comman_loading_image').show();

        /************ Put Here Ajax Code For Add ARP ************/
        /* $.post( '/wp-admin/admin-ajax.php', {
            action: 'updateArpText',
            arpId: arp_id,
            arpText: arp_text
        }, function (response) {
            $('.text_' + arp_id).show();
            $('.input_' + arp_id).hide();
            $('.text_' + arp_id).text(arp_text);
            $('#arp_id_'.arp_id).val(arp_text);
            $('#arp_save_btn_' +arp_id).hide();
            $('#arp_cancel_btn_' + arp_id).hide();
            $('.edit_arp_' + arp_id).show();
            $('.comman_loading_image').hide();
            generate_pdf_again('57dcc8a264d9e0ae318a9ea6921b56f6');
        }); */
    });
    

    if ($('#student_level').val() != '') {
        $('.CA_' + $('#student_level').val() + '_container').show();
        $('.CA_' + (parseInt($('#student_level').val()) + 1) + '_container').show();
        $('.CA_' + (parseInt($('#student_level').val()) - 1) + '_container').show();
    }

    $(document).on('click', '.loadlevelanchor', function () {
        val = $(this).data('atr');
        $('#dropdown-toggle-1').toggle();
        $('.points_to_improve_prev_lesson').hide();
        $('.strong_points_prev_lesson').hide();
        $('.comman_loading_image').show();
        $('#last_clicked_item').val(val);
        var stu_cnt = $('#student_level').val();
        if (stu_cnt) {
            if ($('#response_div_points_to_improve').find('.' + val + '_' + '8' + '_container').length > 0 ||
                $('#response_div_strong_points').find('.' + val + '_' + '8' + '_container').length > 0) {
                $('.' + val + '_' + '8' + '_container').show();
                $('.' + val + '_' + '8' + '_container').show();
                $('.comman_loading_image').hide();
            } else {
                $.post('/wp-admin/admin-ajax.php', {
                        action: 'getNextLevelsAndPoints',
                        level_type: val,
                        student_level: '8',
                        student_id: 1232,
                        point_type: 'strong_points'
                    },
                    function (response) {
                        $('.comman_loading_image').hide();
                        $('#response_div_points_to_improve').prepend(response);
                        $('.' + val + '_' + 8 + '_container').show();
                        $('.editable-dropdown .' + val)
                            .attr('onclick', 'showhiddenlevels("' + val + '")');
                    }
                );
            }

            if ($('#response_div_points_to_improve').find('.' + val + '_' + '9' + '_container').length > 0 ||
                $('#response_div_strong_points').find('.' + val + '_' + '9' + '_container').length > 0) {
                $('.' + val + '_' + '9' + '_container').show();
                $('.' + val + '_' + '9' + '_container').show();
                $('.comman_loading_image').hide();
            } else {
                $('.comman_loading_image').show();
                $.post('/wp-admin/admin-ajax.php', {
                        action: 'getNextLevelsAndPoints',
                        level_type: val,
                        student_level: '9',
                        student_id: 1232,
                        point_type: 'strong_points'
                    },
                    function (response) {
                        $('.comman_loading_image').hide();
                        $('#response_div_strong_points').append(response);
                        $('.' + val + '_' + 9 + '_container').show();
                        $('.editable-dropdown .' + val).attr('onclick', 'showhiddenlevels("' + val + '")');
                    }
                );
            }
            if ($('#response_div_points_to_improve').find('.' + val + '_' + '7' + '_container').length > 0 ||
                $('#response_div_strong_points').find('.' + val + '_' + '7' + '_container').length > 0) {
                $('.' + val + '_' + '7' + '_container').show();
                $('.' + val + '_' + '7' + '_container').show();
                $('.comman_loading_image').hide();
            } else {
                $('.comman_loading_image').show();
                $.post('/wp-admin/admin-ajax.php', {
                        action: 'getNextLevelsAndPoints',
                        level_type: val,
                        student_level: '7',
                        student_id: 1232,
                        point_type: 'strong_points'
                    },
                    function (
                        response) {
                        $('.comman_loading_image').hide();
                        $('#response_div_points_to_improve').append(response);
                        $('.' + val + '_' + 7 + '_container').show();
                        $('.editable-dropdown .' + val).attr('onclick', 'showhiddenlevels("' + val + '")');
                    }
                );
            }
        }
    });
	
	$('#progress_rating_div').on('click', function() {
		if($(this).hasClass('collapsed')){			
			$('#alert-message-9').show();	
		}
	});
});

function getSelectionHtml() {
    //replaceCopiedText();
    var html = "";
    var last_final_text = '';
    html = $('#editor_textarea').html();
    html = html.replace(/&nbsp;/gi, ' ');
    //html = searchReplace(html, '<div><br></div>', "<br>");

    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    if (isChrome || isSafari) {
        html = searchReplace(html, '<br>', "");
    }

    html = searchReplace(html, '<div>', "");
    html = searchReplace(html, '</div>', "<br>");
    html = searchReplace(html, '<br><br><br><br>', "<br><br>");
    html = searchReplace(html, '<br><br><br>', "<br><br>");

    $('#editor_textarea').html(html);
    lines = html.split("<br>");

    var total_length = parseInt(lines.length) - 1;
    var lines_array = [];
    var html_after_translation = '';

    var count_correct_lines = '';
    var count_incorrect_lines = '';
    for (i = 0; i <= total_length; i++) {
        if (lines[i] != '' && lines[i] != 'undefined') {
            var OChar = lines[i].split(" ").pop();
            if (OChar != '' && (OChar == 'o' || OChar == 'O')) {
                count_correct_lines = count_correct_lines + 1;
            }

            if (OChar != '' && (OChar == 'x' || OChar == 'X')) {
                count_incorrect_lines = count_incorrect_lines + 1;
            }

        }
    }

    if (count_correct_lines != count_incorrect_lines) {
        alert('Before we can wrap, partner, just make sure the Incorrect and Corrected Phrases are all good!');
        return false;
    }

    for (i = 0; i <= total_length; i++) {
        if (lines[i] != '' && lines[i] != 'undefined') {
            lines_array.push(lines[i]);
            if (lines_array.length <= 2 && html_after_translation != '') {
                html_after_translation = html_after_translation + '<br>';
            }
        } else {
            if (lines_array.length == 2) {
                var first_line = lines_array[0];
                var second_line = lines_array[1];
                var OChar = first_line.split(" ").pop();
                var XChar = second_line.split(" ").pop();
                if (((OChar == 'O' || OChar == 'o') && (XChar == 'X' || XChar == 'x')) || ((OChar == 'X' || OChar == 'x') && (XChar == 'O' || XChar == 'o'))) {
                    if ((first_line.split(" ").pop() == 'O' ||
                            first_line.split(" ").pop() == 'o') &&
                        (second_line.split(" ").pop() == 'X' ||
                            second_line.split(" ").pop() == 'x')) {

                        var show_string = first_line.substring(0,
                            first_line.lastIndexOf(" "));
                        var after_replace = strip_tags('<div>' +
                            show_string + '<div>');
                        //after_replace = searchReplace(after_replace, ' ?', '?');
                        after_replace = after_replace + '\n';
                        after_replace = searchReplace(after_replace, '{', '');
                        after_replace = searchReplace(after_replace, '}', '');
                        after_replace = encodeURI(after_replace);

                        var relaced_with =
                            '<div class="correct_incorrect"><span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                            after_replace + '">' + show_string +
                            '</a></b></span>';

                        editor_text = $('#editor_textarea').html();

                        $('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                        html_after_translation = html_after_translation + relaced_with + '<br>';

                        var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                        var after_replace = strip_tags('<div>' + show_string + '</div>');
                        //after_replace = searchReplace(after_replace, ' ?', '?');
                        after_replace = after_replace + '\n';
                        after_replace = searchReplace(after_replace, '{', '');
                        after_replace = searchReplace(after_replace, '}', '');
                        after_replace = encodeURI(after_replace);
                        var relaced_with =
                            '<strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                            after_replace + '">' + show_string +
                            '</a></b></strike></div>';
                        editor_text = $('#editor_textarea').html();
                        $('#editor_textarea').html(editor_text.replace(second_line, relaced_with));
                        html_after_translation = html_after_translation + relaced_with + '<br>';
                    }

                    if ((first_line.split(" ").pop() == 'X' ||
                            first_line.split(" ").pop() == 'x') && (
                            second_line.split(" ").pop() == 'O' ||
                            second_line.split(" ").pop() == 'o')) {

                        var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                        var after_replace = strip_tags('<div>' + show_string + '</div>');
                        //after_replace = searchReplace(after_replace, ' ?', '?');
                        after_replace = after_replace + '\n';
                        after_replace = searchReplace(after_replace, '{', '');
                        after_replace = searchReplace(after_replace, '}', '');
                        after_replace = encodeURI(after_replace);
                        var relaced_with =
                            '<div class="correct_incorrect"><strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                            after_replace + '">' + show_string +
                            '</a></b></strike>';
                        editor_text = $('#editor_textarea').html();
                        $('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                        html_after_translation = html_after_translation + relaced_with + '<br>';

                        var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                        var after_replace = strip_tags('<div>' + show_string + '</div>');
                        //after_replace = searchReplace(after_replace, ' ?', '?');
                        after_replace = after_replace + '\n';
                        after_replace = searchReplace(after_replace, '{', '');
                        after_replace = searchReplace(after_replace, '}', '');
                        after_replace = encodeURI(after_replace);
                        var relaced_with =
                            '<span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                            after_replace + '">' + show_string +
                            '</a></b></span></div>';
                        editor_text = $('#editor_textarea').html();
                        $('#editor_textarea').html(editor_text.replace(second_line, relaced_with));

                        html_after_translation = html_after_translation + relaced_with + '<br>';
                    }

                } else {

                    if ((lines_array[0] != '' && lines_array[0] != 'undefined') && (lines_array[1] != '' && lines_array[1] != 'undefined')) {

                        new_string = lines_array[0] + '<br>' + lines_array[1];
                        var link_string = lines_array[0] + '\n' + lines_array[1];
                        var one_mor_str = searchReplace(link_string, '{', '');
                        var final_link = searchReplace(one_mor_str, '}', '');
                        final_link = encodeURI(final_link);
                        //final_link = searchReplace(final_link, ' ?', '?');
                        var relaced_with =
                            '<span class="arp" style="display: inline"><b><a class="arp_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                            final_link + '">' + new_string +
                            '</a></b></span>';

                        editor_text = $('#editor_textarea').html();

                        $('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                        html_after_translation = html_after_translation + relaced_with + '<br>';
                    } else {

                        new_string = lines_array[0] + '<br>' + lines_array[1];
                        var link_string = lines_array[0] + '\n' + lines_array[1];
                        var one_mor_str = searchReplace(link_string, '{', '');
                        var final_link = searchReplace(one_mor_str, '}', '');
                        final_link = encodeURI(final_link);

                        var relaced_with =
                            '<span class="" style="display: inline"><b><a class="" target="_blank" href="https://translate.google.com/#en/ja/' +
                            final_link + '">' + new_string +
                            '</a></b></span>';

                        editor_text = $('#editor_textarea').html();
                        $('#editor_textarea').html(editor_text
                            .replace(new_string, relaced_with));
                        html_after_translation =
                            html_after_translation + relaced_with +
                            '<br>';
                    }
                }
                lines_array = [];
            } else {
                for (x = 0; x < lines_array.length; x++) {
                    if (lines_array[x].trim() != '' && lines_array[x] !=
                        'undefined') {

                        if (lines_array[x].indexOf('http://') != '-1' ||
                            lines_array[x].indexOf('https://') != '-1'
                        ) {

                            if (lines_array[x] != '' && lines_array[
                                    x] != 'undefined') {

                                var relaced_with =
                                    '<b><a class="google_translate_link" target="_blank" href="' +
                                    lines_array[x] + '">' + lines_array[
                                        x] + '</a></b>';
                                editor_text = $('#editor_textarea')
                                    .html();
                                $('#editor_textarea').html(
                                    editor_text.replace(lines_array[
                                        x], relaced_with));

                                html_after_translation =
                                    html_after_translation +
                                    relaced_with + '<br>';
                            }
                        } else {
                            if (lines_array[x].trim() != '' &&
                                lines_array[x] != 'undefined') {

                                new_string = lines_array[x];
                                new_string = searchReplace(new_string,
                                    '{', '');
                                new_string = searchReplace(new_string,
                                    '}', '');
                                new_string = encodeURI(new_string);
                                //new_string = searchReplace(new_string, ' ?', '?');
                                var relaced_with =
                                    '<b><a class="google_translate_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                                    new_string + '">' + lines_array[x] +
                                    '</a></b>';
                                editor_text = $('#editor_textarea')
                                    .html();
                                $('#editor_textarea').html(
                                    editor_text.replace(lines_array[
                                        x], relaced_with));

                                html_after_translation =
                                    html_after_translation +
                                    relaced_with + '<br>';
                            }
                        }

                    }

                }
                lines_array = [];
            }
        }
    }

    if (lines_array.length == 2) {
        var first_line = lines_array[0];
        var second_line = lines_array[1];
        var OChar = first_line.split(" ").pop();
        var XChar = second_line.split(" ").pop();
        if (((OChar == 'O' || OChar == 'o') && (XChar == 'X' || XChar == 'x')) ||
            ((OChar == 'X' || OChar == 'x') && (XChar == 'O' || XChar == 'o'))) {

            if ((first_line.split(" ").pop() == 'O' || first_line.split(" ").pop() == 'o') &&
                (second_line.split(" ").pop() == 'X' || second_line.split(" ").pop() == 'x')) {

                var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                var after_replace = strip_tags('<div>' + show_string + '<div>');
                //after_replace = searchReplace(after_replace, ' ?', '?');
                after_replace = after_replace + '\n';
                after_replace = searchReplace(after_replace, '{', '');
                after_replace = searchReplace(after_replace, '}', '');
                after_replace = encodeURI(after_replace);

                var relaced_with =
                    '<div class="correct_incorrect"><span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                    after_replace + '">' + show_string +
                    '</a></b></span>';
                editor_text = $('#editor_textarea').html();
                $('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                html_after_translation = html_after_translation + relaced_with + '<br>';

                var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                var after_replace = strip_tags('<div>' + show_string + '</div>');
                //after_replace = searchReplace(after_replace, ' ?', '?');
                after_replace = after_replace + '\n';
                after_replace = searchReplace(after_replace, '{', '');
                after_replace = searchReplace(after_replace, '}', '');
                after_replace = encodeURI(after_replace);
                var relaced_with =
                    '<strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                    after_replace + '">' + show_string +
                    '</a></b></strike></div>';
                editor_text = $('#editor_textarea').html();
                $('#editor_textarea').html(editor_text.replace(second_line, relaced_with));
                html_after_translation = html_after_translation + relaced_with + '<br>';
            }

            if ((first_line.split(" ").pop() == 'X' || first_line.split(" ").pop() == 'x') &&
                (second_line.split(" ").pop() == 'O' || second_line.split(" ").pop() == 'o')) {

                var show_string = first_line.substring(0, first_line.lastIndexOf(" "));
                var after_replace = strip_tags('<div>' + show_string + '</div>');
                //after_replace = searchReplace(after_replace, ' ?', '?');
                after_replace = after_replace + '\n';
                after_replace = searchReplace(after_replace, '{', '');
                after_replace = searchReplace(after_replace, '}', '');
                after_replace = encodeURI(after_replace);
                var relaced_with =
                    '<div class="correct_incorrect"><strike class="incorrect" data-sort="2"><b><a class="incorrect_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                    after_replace + '">' + show_string +
                    '</a></b></strike>';
                editor_text = $('#editor_textarea').html();
                $('#editor_textarea').html(editor_text.replace(first_line, relaced_with));

                html_after_translation = html_after_translation + relaced_with + '<br>';

                var show_string = second_line.substring(0, second_line.lastIndexOf(" "));
                var after_replace = strip_tags('<div>' + show_string + '</div>');
                //after_replace = searchReplace(after_replace, ' ?', '?');
                after_replace = after_replace + '\n';
                after_replace = searchReplace(after_replace, '{', '');
                after_replace = searchReplace(after_replace, '}', '');
                after_replace = encodeURI(after_replace);
                var relaced_with =
                    '<span class="correct" data-sort="1"><b><a class="correct_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                    after_replace + '">' + show_string +
                    '</a></b></span></div>';
                editor_text = $('#editor_textarea').html();
                $('#editor_textarea').html(editor_text.replace(second_line, relaced_with));

                html_after_translation = html_after_translation + relaced_with + '<br>';
            }

        } else {

            new_string = lines_array[0] + '<br>' + lines_array[1];
            var link_string = lines_array[0] + '\n' + lines_array[1];
            var one_mor_str = searchReplace(link_string, '{', '');
            var final_link = searchReplace(one_mor_str, '}', '');
            final_link = encodeURI(final_link);

            if ((lines_array[0] != '' && lines_array[0] != 'undefined') && (lines_array[1] != '' && lines_array[1] != 'undefined')) {
                //final_link = searchReplace(final_link, ' ?', '?');
                var relaced_with =
                    '<span class="arp" style="display: inline"><b><a class="arp_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                    final_link + '">' + new_string + '</a></b></span>';

                editor_text = $('#editor_textarea').html();

                $('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                html_after_translation = html_after_translation + relaced_with + '<br>';
            } else {
                var relaced_with =
                    '<span class="" style="display: inline"><b><a class="" target="_blank" href="https://translate.google.com/#en/ja/' + final_link + '">' + new_string + '</a></b></span>';

                editor_text = $('#editor_textarea').html();
                $('#editor_textarea').html(editor_text.replace(new_string, relaced_with));
                html_after_translation = html_after_translation + relaced_with + '<br>';
            }
        }
        lines_array = [];
    } else {
        for (x = 0; x < lines_array.length; x++) {

            if (lines_array[x].trim() != '' && lines_array[x] != 'undefined') {

                if (lines_array[x].indexOf('http://') != '-1' ||
                    lines_array[x].indexOf('https://') != '-1') {

                    if (lines_array[x] != '' && lines_array[x] != 'undefined') {
                        var relaced_with = '<b><a class="google_translate_link" target="_blank" href="' +
                            lines_array[x] + '">' + lines_array[x] + '</a></b>';
                        editor_text = $('#editor_textarea').html();
                        $('#editor_textarea').html(editor_text.replace(lines_array[x], relaced_with));

                        html_after_translation = html_after_translation + relaced_with + '<br>';
                    }
                } else {
                    if (lines_array[x].trim() != '' && lines_array[x] != 'undefined') {
                        new_string = lines_array[x];
                        new_string = searchReplace(new_string, '{', '');
                        new_string = searchReplace(new_string, '}', '');
                        new_string = encodeURI(new_string);
                        //new_string = searchReplace(new_string, ' ?', '?');
                        var relaced_with =
                            '<b><a class="google_translate_link" target="_blank" href="https://translate.google.com/#en/ja/' +
                            new_string + '">' + lines_array[x] +
                            '</a></b>';
                        editor_text = $('#editor_textarea').html();
                        $('#editor_textarea').html(editor_text.replace(lines_array[x], relaced_with));

                        html_after_translation = html_after_translation + relaced_with + '<br>';
                    }
                }
            }
        }
        lines_array = [];
    }
    html_after_translation = searchReplace(html_after_translation, '<br><br><br><br>', "<br><br>");
    html_after_translation = searchReplace(html_after_translation, '<br><br><br>', "<br><br>");
    $('#editor_textarea').html(html_after_translation);
}

function strip_tags(str) {
    str = str.toString();
    var new_str = str.replace(/<\/?[^>]+>/gi, '');
    return new_str;
}

function revertToOldHtml() {
    $('#preview_button').show();
    $('.botm-eye-icon').show();
    $('#editor_textarea').attr('contenteditable', 'true');
    $('#editor_textarea').html($('#oldHtmlArea').html());
    $('#editor_text_with_brases').html('')
    $('.clicked_not_clicked').val(0);
    $('#previewHtmlAreaParent').hide();
    $('.botm-eye-icon-white').hide();
    $('#bind_field').val(0);

    $('.btn-t1').css('opacity', '1');
    $('.btn-t2').css('opacity', '1');
    $('.btn-t3').css('opacity', '1');
    $('.btn-t4').css('opacity', '1');
    $('#undo').css('opacity', '1');

}

function changeHtml() {
    $('#previewHtmlAreaParent').hide();
}

function replaceAt(s, n, t) {
    return s.substring(0, n) + t + s.substring(n + 1);
}

function replaceTopicTag(str) {
    var regex = /{{/gi,
        result, indices = [];
    while ((result = regex.exec(str))) {
        var indx = result.index;
        var indx2 = str.indexOf("}", indx);
        var str2 = str.substr(indx2 + 1, 1);
        if (str2 == '}') {
            str = replaceAt(str, indx, '<span class="topictag">');
            str = replaceAt(str, indx + 23, '');
            var indx3 = str.indexOf("}", indx + 23);
            str = replaceAt(str, indx3, '</span>');
            str = replaceAt(str, indx3 + 7, '');
        }
    }
    return str;
}

function preview_lesson() {
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    if (isChrome || isSafari) {
        $("#editor_textarea").contents().filter(function () {
            return this.nodeType == Node.TEXT_NODE;
        }).wrap('<div></div>');
    }

    if ($('#bind_field').val() == 0) {
        var openBrace = countInstancesOf($('#editor_textarea').text(), '{');
        var closeBrace = countInstancesOf($('#editor_textarea').text(), '}');
        if (openBrace != closeBrace) {
            alert('There is Mismatch in keyword, keyPhrase, Topic Tag braces please cross check once again');
            return false;
        }

        if ($.trim($('#editor_textarea').text()) != '') {
            $('#editor_textarea').attr('contenteditable', 'false');
            $('#preview_button').hide();
            $('.botm-eye-icon').hide();
            var old_html = $('#editor_textarea').html();
            $('#oldHtmlArea').html(old_html);
            getSelectionHtml();
            var str = $('#editor_textarea').html();
            $('#editor_text_with_brases').html(str);

            str = replaceTopicTag(str);
            str = searchReplace(str, "{", '<span class="keyphrase">');
            str = searchReplace(str, "}", '</span>');

            var myregexp = /<span[^>]+?class="keyphrase".*?>([\s\S]*?)<\/span>/g;
            var match = myregexp.exec(str);
            var result = "";
            var matched_result = [];
            while (match != null) {
                result = RegExp.$1;
                matched_result.push(result);
                match = myregexp.exec(str);
            }
            matched_result.forEach(function (word) {
                if (word.split(" ").length > 1) {
                    str = searchReplace(str, '<span class="keyphrase">' + word + '</span>', '<span class="keyword">' + word + '</span>');
                }
            });

            $('#editor_textarea').html(str);
            /*Create anchor for entered url in canvas end*/

            $('#editor_textarea').html(str);

            $('.topictag').each(function (i, e) {
                if ($(this).html() != '') {
                    $(this).html($(this).html().trim());
                }
            });

            $('.keyword').each(function (i, e) {
                if ($(this).html() != '') {
                    $(this).html($(this).html().trim());
                }
            });

            $('.keyphrase').each(function (i, e) {
                if ($(this).html() != '') {
                    $(this).html($(this).html().trim());
                }
            });

            $('#editor_textarea').each(function () {
                if (this.childNodes[0].tagName && this.childNodes[0].tagName.toLowerCase() == 'br') {
                    $(this.childNodes[0]).remove();
                }
            });

            var topic_tag = $("#editor_textarea .topictag");
            var topic_tag_length = topic_tag.length;
            var topic_tag_html = '';
            if (topic_tag_length > 0) {
                for (z = 0; z < topic_tag_length; z++) {
                    if ($(topic_tag[z]).html() != '') {
                        topic_tag_html += $(topic_tag[z]).html() + ', ';
                    }
                }
            }
            $('.current_lesson_topic').html(topic_tag_html.slice(0, -2));
            $('#previewHtmlAreaParent').show();
            $('.botm-eye-icon-white').show();
            $('.clicked_not_clicked').val(1);
            $('#bind_field').val(1);
            $('.btn-t1').css('opacity', '0.49');
            $('.btn-t2').css('opacity', '0.49');
            $('.btn-t3').css('opacity', '0.49');
            $('.btn-t4').css('opacity', '0.49');
            $('#undo').css('opacity', '0.49');
        } else {
            return false;
        }
    } else {
        $('#alert-preview-mode').modal('show');
        //alert('You are in review mode');
    }
}

function countInstancesOf(str, i) {
    var count = 0;
    var pos = -1;
    while ((pos = str.indexOf(i, pos + 1)) !== -1) ++count;
    return count;
}

function no_wrap_lesson() {
    $('#alert-message-1').hide();
}

function wrap_lesson(action) {
	$('#homework_lesson_task_alert').modal('hide');
    if ($('#stuNoShow').prop('checked') == false) {
        if ($('#editor_textarea').text() == '') {
            //alert('Hey cowboy! At least put something on the canvas before wrapping.');
            //alert-no-comment
            $('#alert-no-canvas').modal('show');
            return false;
        }
    }

    var old_html_content = $('#editor_textarea').val();
    if ($('.clicked_not_clicked').val() == 0) {
        if ($('#response_div_points_to_improve').html() == '' && $('#response_div_strong_points').html == '') {
            alert('Please check atleast one strong points or points to improve must be there before wrap');
            return false;
        }
    }

    if(($("#response_div_strong_points .pnt_intro").length <= 0) && ($('#stuNoShow').prop('checked') == false)){
        if(isAlertRating){
            $('#alert-update-ratings').modal('show');
            return false;
        }
        $('#alert-strong-points').modal('show');
        return false;
    }

    if ($('.clicked_not_clicked').val() == 0) {
        preview_lesson();
    }

    var arp_post_data = '';
    var cor_incor_post_data = '';
    var topic_tag_html = '';
    var not_under_arp = '';
    var keyword_not_under_arp_data = '';
    var keyword_phrase_not_under_arp_data = '';
    var arp_array = $('#editor_text_with_brases span.arp');

    var parp_post_data = [];
    var pcor_incor_post_data = [];
    var pkeyword_not_under_arp_data = [];
    var pkeyword_phrase_not_under_arp_data = [];
    var ptopic_tag_html = [];

    console.log(parp_post_data);
    var arp_length = arp_array.length;
    for (i = 0; i < arp_length; i++) {
        if ($(arp_array[i]).html() != '') {
            arp_post_data += $(arp_array[i]).html() + '^^';
            parp_post_data.push($(arp_array[i]).html());
        }
    }

    var cor_incor_array = $('#editor_text_with_brases div.correct_incorrect');
    var cor_incor_length = cor_incor_array.length;
    for (x = 0; x < cor_incor_length; x++) {
        if ($(cor_incor_array[x]).html() != '') {
            cor_incor_post_data += $(cor_incor_array[x]).html() + '%%';
            pcor_incor_post_data.push($(cor_incor_array[x]).html());
        }
    }

    //var keyword_not_under_arp = $("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");
    var keyword_not_under_arp = $("#editor_textarea .keyword");
    var keyword_not_under_arp_length = keyword_not_under_arp.length;
    for (z = 0; z < keyword_not_under_arp_length; z++) {
        if ($(keyword_not_under_arp[z]).html() != '') {
            keyword_not_under_arp_data += $(keyword_not_under_arp[z]).html() + '**';
            pkeyword_not_under_arp_data.push($(keyword_not_under_arp[z]).html());
        }
    }

    //var keyword_phrase_not_under_arp = $("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
    var keyword_phrase_not_under_arp = $("#editor_textarea .keyphrase");
    var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
    for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {
        if ($(keyword_phrase_not_under_arp[z]).html() != '') {
            keyword_phrase_not_under_arp_data += $(keyword_phrase_not_under_arp[z]).html() + '$$';
            pkeyword_phrase_not_under_arp_data.push($(keyword_phrase_not_under_arp[z]).html());
        }
    }

    var topic_tag = $("#editor_textarea .topictag");
    var topic_tag_length = topic_tag.length;
    for (z = 0; z < topic_tag_length; z++) {
        if ($(topic_tag[z]).html() != '') {
            topic_tag_html += $(topic_tag[z]).html() + '*$';
            ptopic_tag_html.push($(topic_tag[z]).html());
        }
    }

    // console.log('arp_post_data : - '+arp_post_data);
    // console.log('cor_incor_post_data : - '+cor_incor_post_data);
    // console.log('keyword_not_under_arp_data : - '+keyword_not_under_arp_data);
    // console.log('keyword_phrase_not_under_arp_data : - '+keyword_phrase_not_under_arp_data);
    // console.log('topic_tag_html : - '+topic_tag_html);

    if (topic_tag_html == '' && $('#stuNoShow').prop('checked') == false) {
        //alert('Hey amazing teacher. Not so fast, gotta at least input 1 Topic.');
        $('#alert-no-topic').modal('show');
        return false;
    }

    if ($('#stuNoShow').prop('checked') == false) {
        if (arp_post_data == '') {
            $('#alert-no-arp').modal('show');
            //alert('There must be atleast 1 ARP to successfully wrap this lesson');
            return false;
        }
    }

    if ($('#lesson_comment_textarea').val() == '') {
        //alert-no-comment
        /*$('#alert-no-comment').modal('show');
        //alert('Please enter any text in lesson comment before wrap lesson');
        $('#editor_textarea').val(old_html_content);
        return false;*/
    }
	
	if (($('#points_to_improve_comment_textarea').val() == '')  && ($('#stuNoShow').prop('checked') == false)) {
        //alert-no-comment
        $('#alert_points_to_improve_comment').modal('show');
        //alert('Please enter any text in lesson comment before wrap lesson');
        //$('#editor_textarea').val(old_html_content);
        return false;
    }
	
	if (($('#strong_points_comment_textarea').val() == '')  && ($('#stuNoShow').prop('checked') == false)) {
        //alert-no-comment
        $('#alert_strong_points_comment').modal('show');
        //alert('Please enter any text in lesson comment before wrap lesson');
        //$('#editor_textarea').val(old_html_content);
        return false;
    }

    $(".strong_points").each(function () {
        $(this).prop("checked", 'checked');
    });

    $(".points_to_improve").each(function () {
        $(this).prop("checked", 'checked');
    });

    var p_to_i = [];
    $('#response_div_points_to_improve div :checked').each(function (i, e) {
        if ($(this).val() != '') {
            p_to_i.push($(this).val());
        }
    });

    var s_points = [];
    $('#response_div_strong_points div :checked').each(function (i, e) {
        if ($(this).val() != '') {
            s_points.push($(this).val());
        }
    });

    var homeWork_task = [];
    $('.ac-st-lesson-task').each(function (i, e) {
        let task = {
            name: $(this).attr('name'),
            value: $(this).val()
        };
        homeWork_task.push(task);
    });
	var canvas_html = '';
	if($('#stuNoShow').prop('checked') == false) {
		if ($('.clicked_not_clicked').val() == 0) {
			if ($('#editor_textarea').text() != '') {
				canvas_html = $('#editor_textarea').html();
			} else {
				return false;
			}
		} else {
			if ($('#oldHtmlArea').text() != '') {
				canvas_html = $('#oldHtmlArea').html()
			} else {
				return false;
			}
		}
	}

    var lesson_comment = $('#lesson_comment_textarea').val();
    var points_to_improve_comment_textarea = $('#points_to_improve_comment_textarea').val();
    var strong_points_comment_textarea = $('#strong_points_comment_textarea').val();

    /*console.log(p_to_i);
    console.log(s_points);
    console.log(homeWork_task);
    console.log(canvas_html);

    console.log(arp_post_data);
    console.log(cor_incor_post_data);
    console.log(keyword_not_under_arp_data);
    console.log(keyword_phrase_not_under_arp_data);
    console.log(topic_tag_html);

    console.log(pcor_incor_post_data);*/

    var show_comment_to_student = $('#stuNoShow').prop('checked') ? 1 : 2;
    var swal_title = $('#stuNoShow').prop('checked') ? 'Are you sure it is student no show?' : 'Made sure the notes are written and formatted correctly?';

    var pData = {
        'point_to_improve': p_to_i,
        'strong_points': s_points,
        'lesson_id' : lessonID,
        'tasks': homeWork_task,
        'canvas_html': canvas_html,
        'arp_data': arp_post_data,
        'cor_incor_data': cor_incor_post_data,
        'keyword_not_under_arp_data': keyword_not_under_arp_data,
        'keyword_phrase_not_under_arp_data': keyword_phrase_not_under_arp_data,
        'topic_tag_html': topic_tag_html,
        'show_comment_to_student': show_comment_to_student,
        'lesson_comment': lesson_comment,
        'strong_points_comment_textarea': strong_points_comment_textarea,
        'points_to_improve_comment_textarea': points_to_improve_comment_textarea,
        'booking_id' : bookingID,
        'canva_htm' : $('#editor_textarea').html(),
        'ca_rating' :  $('#ca_rating').val(),
        'fp_rating' :  $('#fp_rating').val(),
        'lc_rating' :  $('#lc_rating').val(),
        'v_rating'  :  $('#v_rating').val(),
        'ga_rating' :  $('#ga_rating').val(),
        'onepage_level_id' : $('#student_lesson_level').val(),
        'filter_point_type' : $("#filter_point_type").val()
    }

    swal({
        title: swal_title,
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, Wrap it!",
        closeOnConfirm: true
    },
    function(isConfirm){
        console.log(isConfirm);
        if (isConfirm) {
			scrollToAnchor('headingOne');
            $('#alert-message-6').modal('show');

            countdown();
            var myVar;
            myVar = setTimeout( function()  {
                $.ajax({
                    data: pData,
                    url: wrapUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        //$('#student-lesson-profile-detail').html('');
                        //$('.app-loader').removeClass('d-none');
                    },
                    success: function (res) {
						if (res.type == 'success' && res.url !='') {
						
							window.location = res.url;
						} 
						
						if (res.type == 'snoshow' && res.url !='') {
							$.toast({
                                heading: 'Success',
                                text: res.message,
                                position: 'top-right',
                                icon: 'success'
                            });
						
							window.location = res.url;
						}
                        /*if (res.type == 'success') {
                            $('#alert-message-6').modal('hide');
                            //$('.app-loader').addClass('d-none');
                            $('#one-page-canvas-container').html(res.html);
                            $('#one-page-session-container').html(res.lessons);
                            $('#onepage-session-canvas').collapse('show');

                            $.toast({
                                heading: 'Success',
                                text: res.message,
                                position: 'top-right',
                                icon: 'success'
                            });
                        }

                        if (res.type == 'failure') {
                            $.toast({
                                heading: 'Failure',
                                text: res.message,
                                position: 'top-right',
                                icon: 'error'
                            });

                            //$('.app-loader').addClass('d-none');
                        }*/
                    }
                });
            }, 10000);

            $('#undo_popup').click(function() {
                $(".strong_points").each(function () {
                    $(this).prop("checked", false);
                });

                $(".points_to_improve").each(function () {
                    $(this).prop("checked", false);
                });
                $('#alert-message-6').modal('hide');
                $('.app-loader').addClass('d-none');
                clearTimeout(myVar);
            });
        }
    });
}

function check_keyword_entered() {
    if ($('#stuNoShow').prop('checked') == false) {
        keyword_len = $("#editor_textarea .keyword").length;
        keyphrase_len = $("#editor_textarea .keyphrase").length;

        if ((keyword_len == '' || keyword_len == 0) && (keyphrase_len == '' || keyphrase_len == 0)) {
            $('.modal').hide();
            $('#alert-message-3').modal('show');
        } else {
            finaly_wrap_lesson();
        }
    } else {
        finaly_wrap_lesson();
    }
}

function check_homework_task() {
	if ((($('#homework_lessons_material_and_tasks_2').val().trim().length < 1) && ($('#homework_lessons_material_and_tasks_3').val().trim().length < 1) && ($('#next_lessons_tasks_2').val().trim().length < 1) && ($('#next_lessons_tasks_3').val().trim().length < 1)) && ($('#stuNoShow').prop('checked') == false)) {
			//alert-no-comment
			$('#homework_lesson_task_alert').modal('show');
			//return false;
	} else {
		wrap_lesson('wrap');
	}
}

function finaly_wrap_lesson() {
    $('.comman_loading_image').show();
    $('#alert-message-1').hide();
    $('#alert-message-2').hide();
    $('#alert-message-3').hide();
    $('#alert-message-4').hide();
    var arp_post_data = '';
    var cor_incor_post_data = '';
    var topic_tag_html = '';
    var not_under_arp = '';
    var keyword_not_under_arp_data = '';
    var keyword_phrase_not_under_arp_data = '';
    var p_to_i = [];
    var s_points = [];
    var homeWork_task = [];
    var lesson_material_task = [];
    var lesson_task = [];
    var next_lesson_task = [];
    if ($('#stuNoShow').prop('checked') == false) {
        var arp_array = $('#editor_text_with_brases span.arp');
        var arp_length = arp_array.length;
        for (i = 0; i < arp_length; i++) {
            if ($(arp_array[i]).html() != '') {
                arp_post_data += $(arp_array[i]).html() + '^^';
            }
        }

        var cor_incor_array = $('#editor_text_with_brases div.correct_incorrect');
        var cor_incor_length = cor_incor_array.length;

        for (x = 0; x < cor_incor_length; x++) {
            if ($(cor_incor_array[x]).html() != '') {
                cor_incor_post_data += $(cor_incor_array[x]).html() + '%%';
            }
        }

        var keyword_not_under_arp = $("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");

        var keyword_not_under_arp_length = keyword_not_under_arp.length;
        for (z = 0; z < keyword_not_under_arp_length; z++) {
            if ($(keyword_not_under_arp[z]).html() != '') {
                keyword_not_under_arp_data += $(keyword_not_under_arp[z]).html() + '**';
            }
        }

        var keyword_phrase_not_under_arp = $("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");
        var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;
        for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {
            if ($(keyword_phrase_not_under_arp[z]).html() != '') {
                keyword_phrase_not_under_arp_data += $(keyword_phrase_not_under_arp[z]).html() + '$$';
            }
        }

        var topic_tag = $("#editor_textarea .topictag");
        var topic_tag_length = topic_tag.length;
        for (z = 0; z < topic_tag_length; z++) {
            if ($(topic_tag[z]).html() != '') {
                topic_tag_html += $(topic_tag[z]).html() + '*$';
            }
        }
    }
}

function save_for_next_lessons() {
    $('.comman_loading_image').show();
    $('#alert-message-2').show();
    var arp_post_data = '';
    var cor_incor_post_data = '';
    var topic_tag_html = '';
    var not_under_arp = '';
    var keyword_not_under_arp_data = '';
    var keyword_phrase_not_under_arp_data = '';
    var arp_array = $('#editor_text_with_brases span.arp');
    var arp_length = arp_array.length;

    for (i = 0; i < arp_length; i++) {
        if ($(arp_array[i]).html() != '') {
            arp_post_data += $(arp_array[i]).html() + '^^';
        }
    }
    var cor_incor_array = $('#editor_text_with_brases div.correct_incorrect');

    var cor_incor_length = cor_incor_array.length;

    for (x = 0; x < cor_incor_length; x++) {
        if ($(cor_incor_array[x]).html() != '') {
            cor_incor_post_data += $(cor_incor_array[x]).html() + '%%';
        }
    }

    var keyword_not_under_arp = $("#editor_textarea .keyword").not("#editor_textarea .arp .keyword");

    var keyword_not_under_arp_length = keyword_not_under_arp.length;

    for (z = 0; z < keyword_not_under_arp_length; z++) {
        if ($(keyword_not_under_arp[z]).html() != '') {
            keyword_not_under_arp_data += $(keyword_not_under_arp[z]).html() + '**';
        }
    }

    var keyword_phrase_not_under_arp = $("#editor_textarea .keyphrase").not("#editor_textarea .arp .keyphrase");

    var keyword_phrase_not_under_arp_length = keyword_phrase_not_under_arp.length;

    for (z = 0; z < keyword_phrase_not_under_arp_length; z++) {
        if ($(keyword_phrase_not_under_arp[z]).html() != '') {
            keyword_phrase_not_under_arp_data += $(keyword_phrase_not_under_arp[z]).html() + '$$';
        }
    }

    var topic_tag = $("#editor_textarea .topictag");
    var topic_tag_length = topic_tag.length;
    for (z = 0; z < topic_tag_length; z++) {
        if ($(topic_tag[z]).html() != '') {
            topic_tag_html += $(topic_tag[z]).html() + '*$';
        }
    }

    var next_lesson_task = [];
    $('.next_lesson_task').each(function (i, e) {});

    if ($('.clicked_not_clicked').val() == 0) {
        if ($('#editor_textarea').text() != '') {
            canvas_html = $('#editor_textarea').html();
        } else {
            return false;
        }
    } else {
        if ($('#oldHtmlArea').text() != '') {
            canvas_html = $('#oldHtmlArea').html()
        } else {
            return false;
        }
    }
}

function searchReplace(str, search, replacement) {
    return str.replace(new RegExp(search, 'g'), replacement);
}

function updateButtons(history) {
    $('#undo').attr('disabled', !history.canUndo());
    $('#redo').attr('disabled', !history.canRedo());
}

function setEditorContents(contents) {
    $('#editor_textarea').html(contents);
}

function keep_focus() {
    var t = $("#editor_textarea");
    var l = $("#editor_textarea").html().length;
    $(t).focus();
}

$(function () {
    var counter = 0;
    var history = new SimpleUndo({
        maxLength: 500,
        provider: function (done) {
            done($('#editor_textarea').html());
        },
        onUpdate: function () {
            //onUpdate is called in constructor, making history undefined
            if (!history)
                return;
            updateButtons(history);
        }
    });

    $('#undo').click(function () {
        history.undo(setEditorContents);
    });
    $('#redo').click(function () {
        history.redo(setEditorContents);
    });
    $('#editor_textarea').keypress(function () {
        history.save();
    });
    $('.btn-t1').click(function () {
        history.save();
    });
    $('.btn-t2').click(function () {
        history.save();
    });
    $('.btn-t3').click(function () {
        history.save();
    });
    $('#editor_textarea').on('focus', function () {
        history.save();
    });
    updateButtons(history);
});


function countdown() {
    var timeleft = 10;
    var downloadTimer = setInterval(function(){
        document.getElementById("countdown").innerHTML = timeleft + "  ";
        timeleft -= 1;
        $('#undo_popup').click(function() {
            $('.comman_loading_image').hide();
            document.getElementById("countdown").innerHTML = "";
            clearInterval(downloadTimer);
        });
        if(timeleft <= 0){
            clearInterval(downloadTimer);
            document.getElementById("countdown").innerHTML = "Wrapping..."
            document.getElementById("undo_popup").innerHTML = ""
        }
    }, 1000);
}

// Autosave canvas whenever the inner html of the canvas is changed
setInterval(function(){
    var booking_id = $('#editor_textarea').attr('data-booking-id');
    var canvas_html = "";
    var lessons_material_and_tasks_1 = $("#lessons_material_and_tasks_1").val();
    var lessons_material_and_tasks_2 = $("#lessons_material_and_tasks_2").val();
    var lessons_material_and_tasks_3 = $("#lessons_material_and_tasks_3").val();
    var lessons_tasks_1 = $("#lessons_tasks_1").val();
    var lessons_tasks_2 = $("#lessons_tasks_2").val();
    var lessons_tasks_3 = $("#lessons_tasks_3").val();
    var homework_lessons_material_and_tasks_1 = $("#homework_lessons_material_and_tasks_1").val();
    var homework_lessons_material_and_tasks_2 = $("#homework_lessons_material_and_tasks_2").val();
    var homework_lessons_material_and_tasks_3 = $("#homework_lessons_material_and_tasks_3").val();
    var next_lessons_tasks_1 = $("#next_lessons_tasks_1").val();
    var next_lessons_tasks_2 = $("#next_lessons_tasks_2").val();
    var next_lessons_tasks_3 = $("#next_lessons_tasks_3").val();
    var points_to_improve_comment_textarea = $("#points_to_improve_comment_textarea").val();
    var strong_points_comment_textarea = $("#strong_points_comment_textarea").val();
    var lesson_comment_textarea = $("#lesson_comment_textarea").val();
	
	var ca_rating = $('#ca_rating').val();
    var fp_rating = $('#fp_rating').val();
    var lc_rating = $('#lc_rating').val();
    var v_rating = $('#v_rating').val();
    var ga_rating = $('#ga_rating').val();
		
    if($('#editor_textarea').attr('contenteditable') == 'true') {
        $('#editor_text_with_brases').html($('#editor_textarea').html());
        canvas_html = $('#editor_text_with_brases').html();
    }
	
	var p_to_i = [];
    $('#response_div_points_to_improve div :checkbox').each(function (i, e) {
        if ($(this).val() != '') {
            p_to_i.push($(this).val());
        }
    });

    var s_points = [];
    $('#response_div_strong_points div :checkbox').each(function (i, e) {
        if ($(this).val() != '') {
            s_points.push($(this).val());
        }
    });
	
    //Show / hide close button on modal
    /*if(
    (
        lessons_material_and_tasks_2 == homework_lessons_material_and_tasks_2 && 
        lessons_material_and_tasks_3 == homework_lessons_material_and_tasks_3 &&
        lessons_tasks_2 == next_lessons_tasks_2 &&
        lessons_tasks_3 == next_lessons_tasks_3 
    )
    ||
    (
        lessons_material_and_tasks_2 == "" &&
        lessons_material_and_tasks_3 == "" &&
        lessons_tasks_2 == "" &&
        lessons_tasks_3 == ""
    )    
    ||
    (lessons_material_and_tasks_2 != '' && lessons_material_and_tasks_3 != '' && homework_lessons_material_and_tasks_2 != '' && homework_lessons_material_and_tasks_3 != '' && lessons_tasks_2 != '' && lessons_tasks_3 != '' && next_lessons_tasks_2 != '' && next_lessons_tasks_3  != '' && lessons_material_and_tasks_2 != '' && lessons_material_and_tasks_3 != '' && lessons_tasks_2 != '' && lessons_tasks_3 != '')
	)
	{
        console.log("Show");
        $(".modal-header .close").show();
    }else{
        console.log("Hide");
        $(".modal-header .close").hide();
    }*/
	
	var str_left = '';
		$(".lmdiv").on('click touchstart', function() {
			//$(this).addClass("grey i");
		  var valu = $(this).attr("data-attr");
		  if(valu == 1) {		  
			  var currentvalue = $('#lessons_material_and_tasks_1').val();
			  $("#homework_lessons_material_and_tasks_1").val(currentvalue);
		  } else if(valu == 2) {		  
			  var currentvalue = $('#lessons_material_and_tasks_2').val();
			  $("#homework_lessons_material_and_tasks_2").val(currentvalue);
			  str_left = search_remove_str('lessons_material_and_tasks_2', ',');
			  $('#show_close_btn').val(str_left);
		  } else if(valu == 3) {		  
			  var currentvalue = $('#lessons_material_and_tasks_3').val();
			  $("#homework_lessons_material_and_tasks_3").val(currentvalue);
			  str_left = search_remove_str('lessons_material_and_tasks_3', ',');
			  $('#show_close_btn').val(str_left);
		  }
		  if(str_left == '') {
			  $('.close').show();
			  //$('.close-popup-bottom').show();
			}
		});
		
		$(".ltdiv").on('click touchstart', function() {
			//$(this).addClass("grey i");
		  var valu = $(this).attr("data-attr");
		  if(valu == 1) {		  
			  var currentvalue = $('#lessons_tasks_1').val();
			  $("#next_lessons_tasks_1").val(currentvalue);
		  } else if(valu == 2) {		  
			  var currentvalue = $('#lessons_tasks_2').val();
			  $("#next_lessons_tasks_2").val(currentvalue);
			  str_left = search_remove_str('lessons_tasks_2', ',');
			  $('#show_close_btn').val(str_left);
		  } else if(valu == 3) {		  
			  var currentvalue = $('#lessons_tasks_3').val();
			  $("#next_lessons_tasks_3").val(currentvalue);
			  str_left = search_remove_str('lessons_tasks_3', ',');
			  $('#show_close_btn').val(str_left);
		  }
		  if(str_left == '') {
			  $('.close').show();
			  //$('.close-popup-bottom').show();
			}
		});
		
    // Show / hide downbutton
    /*$('.cpy_lessons_tasks').each(function (i, e) {
        if ($(this).prev("textarea").val() != '') {
            $(this).show();
        }else{
            $(this).hide();
        }
    });*/
	var auto_save_url = $("#auto_save_url").val();
    // Send auto save request
    $.ajax({
        //url: "/teacher/auto-save",
        url: auto_save_url,
        method: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            booking_id:booking_id,
			point_to_improve: p_to_i,
			strong_points: s_points,
            lessons_material_and_tasks_1:lessons_material_and_tasks_1,
            lessons_material_and_tasks_2:lessons_material_and_tasks_2,
            lessons_material_and_tasks_3:lessons_material_and_tasks_3,
            lessons_tasks_1:lessons_tasks_1,
            lessons_tasks_2:lessons_tasks_2,
            lessons_tasks_3:lessons_tasks_3,
            homework_lessons_material_and_tasks_1:homework_lessons_material_and_tasks_1,
            homework_lessons_material_and_tasks_2:homework_lessons_material_and_tasks_2,
            homework_lessons_material_and_tasks_3:homework_lessons_material_and_tasks_3,
            next_lessons_tasks_1:next_lessons_tasks_1,
            next_lessons_tasks_2:next_lessons_tasks_2,
            next_lessons_tasks_3:next_lessons_tasks_3,
            canvas_html:canvas_html,
            points_to_improve_comment_textarea:points_to_improve_comment_textarea,
            strong_points_comment_textarea:strong_points_comment_textarea,
            lesson_comment_textarea:lesson_comment_textarea,
            ca_rating:ca_rating,
            fp_rating:fp_rating,
            lc_rating:lc_rating,
            v_rating:v_rating,
            ga_rating:ga_rating,

        }
    });
}, 2000);

$(document).on('keyup', '.compare-tasks', function(e) {
    if ($(this).val() != '') {
        $(this).next("button").show();
    }else{
        $(this).next("button").hide();
    }
})

function search_remove_str(value, separator) {
	var list = $('#show_close_btn').val();
	var nameArr = show_close_btn_val.split(',');
	separator = separator || ",";
	var values = list.split(separator);
	for(var i = 0 ; i < values.length ; i++) {
		if(values[i] == value) {
			values.splice(i, 1);
			return values.join(separator);
		}
	}
	return list;
}

function scrollToAnchor(id){
	$('html, body').animate({
		scrollTop: $("#"+id).offset().top
	}, 2000);
}