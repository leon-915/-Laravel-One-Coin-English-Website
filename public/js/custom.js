$(document).ready(function () {
    $('#nav_open').click(function () {
        $('.toggle_nav_open').slideToggle("fast");
    });

    $(document).on("click", function(event) {
        var trigger = $("#nav_open")[0];
        var dropdown = $(".toggle_nav_open");
        if (dropdown !== event.target && !dropdown.has(event.target).length && trigger !== event.target) {
          $(".toggle_nav_open").hide();
        }
    });
	
	// Test1
	
});


$(document).ready(function () {
    //wizred-form
    $('#wizard1').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '#index# #title#'
    });
});

$(document).on('change','#chooseFile', function(e){
    var filename = $(this).val();
    if (/^\s*$/.test(filename)) {
        $(".file-upload").removeClass('active');
        $("#noFile").text("No file chosen...");
    } else {
        $(".file-upload").addClass('active');
        $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
    }
});

$(document).on('change','.custom-file-upload', function(e){
    var filename = $(this).val();
    if (/^\s*$/.test(filename)) {
        $(this).parent(".file-select").parent(".file-upload").removeClass('active');
        $(this).parent(".file-select").find(".file-select-name").text("No file chosen...");
    } else {
        $(this).parent(".file-select").parent(".file-upload").addClass('active');
        $(this).parent(".file-select").find(".file-select-name").text(filename.replace("C:\\fakepath\\", ""));
    }
});

$('#chooseFile').on('change', function () {
    var filename = $(".chooseFile").val();
    if (/^\s*$/.test(filename)) {
        $(".file-upload").removeClass('active');
        $("#noFile").text("No file chosen...");
    } else {
        $(".file-upload").addClass('active');
        $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
    }
});

$(function () {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        // Variables privadas
        var links = this.el.find('.link');
        // Evento
        links.on('click', {
            el: this.el,
            multiple: this.multiple
        }, this.dropdown)
    }

    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el;
        $this = $(this),
            $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
    }

    var accordion = new Accordion($('#accordion'), false);
});



