$(document).ready(function() {

    $("input[type='submit']").click(function(e){

        $.ajax({ 
            type: "POST",
            url: 'src/FormHandler.php',
            data: $( "#form" ).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#loader').show();
                $("input[type='submit']").hide();
                $("input, textarea").attr('readonly', true);
                // setting first page and getting page messages before new message inserted
                $.ajax({
                    url: "src/AjaxPagination.php",
                    type: "GET",
                    data: {
                        page1 : 1
                    },
                    cache: false,
                    success: function(dataResult){
                        $("#messages-container").html(dataResult);
                    }
                });
            },
            complete: function(){
                $('#loader').hide();
                $("input[type='submit']").show();
                $("input, textarea").attr('readonly', false); 
                $("#form textarea").val('');    
            },
            success: function(data) {
                // check form errors
                if(data.error) {
                    
                    $('#form').find('.error').css('display', 'none');
                    $('#form').children().removeClass('err');

                    $.each(data.error, function(index, value) {

                        var input = $('#form').find('#'+index);
                        input.parent().addClass('err');
                        input.parent().find('.error').html(value).css('display', 'block');
                    });

                } else {

                    var date_add = formatDate();
                    var email = data.email;
                    var messageHtml = '<li><span>'+date_add+'</span>';

                    if (email.length > 4) {

                        messageHtml += '<a href="mailto:'+email+'">'+data.name+', </a>';

                    } else {

                        messageHtml += data.name+', ';

                    }

                    messageHtml += data.age+' m.<br/>'+ data.message+'</li>';

                    var messages_count = $('#messages-container li').length;
                    console.log(messages_count);
                    if (messages_count > 4) {

                        $('#messages-container').children().last().remove();

                    }
                    
                    $('#messages-container').prepend(messageHtml).html();

                    $('.page-link').removeClass("active"); 
                    $('.page-link').first().addClass("active"); 

                    $('#form').find('.error').css('display', 'none');
                    $('#form').children().removeClass('err');

                }
            },
            error: function(error) {
                alert(error.responseText);
            }
        });

        e.preventDefault();

    });

    // messages pages navigation
    $(".page-link").click(function(e){

        var id = $(this).attr("data-id");

        $.ajax({
            url: "src/AjaxPagination.php",
            type: "GET",
            data: {
                page1 : id
            },
            cache: false,
            success: function(dataResult){
                $("#messages-container").html(dataResult);
            },
            error: function(error) {
                alert('Error_ajax_page');
            }
        });

        e.preventDefault();
        $(this).parent().find(".active").removeClass("active");
        $(this).addClass("active"); 

    });


    function formatDate() {

        var currentdate = new Date($.now());

        var month = (currentdate.getMonth()+1);
        var day = currentdate.getDate();
        var hour = currentdate.getHours();
        var min =  currentdate.getMinutes();
        var second = currentdate.getSeconds();


        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        if (hour < 10) {
            hour = "0" + hour;
        }                
        if (min < 10) {
            min = "0" + min;
        }
        if (second < 10) {
            second = "0" + second;
        }
        
        var date = currentdate.getFullYear()+"-"+month+"-"+day+" "+hour+":"+min+":"+second;

        return date;

    }

});