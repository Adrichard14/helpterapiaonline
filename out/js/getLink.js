$(document).ready(function () {

    // Load more data
    $('.load-more-explainer').click(function () {
        var ID = Number($('#ID').val());
        if (row <= allcount) {
            $("#row-explainer").val(row);

            $.ajax({
                url: 'out/getExplainer.php',
                type: 'post',
                data: {
                    ID: ID
                },
                beforeSend: function () {
                    $(".load-more-explainer").text("Carregando...");
                },
                success: function (response) {

                    // Setting little delay while displaying new content
                    setTimeout(function () {
                        // appending posts after last post with class="post"
                        $(".post-explainer:last").after(response).show().fadeIn("slow");

                        var rowno = row + 3;

                        // checking row value is greater than allcount or not
                        if (rowno > allcount) {
                            // Change the text and background
                            $('.load-more-explainer').text("Ver menos");
                            // $('.load-more-explainer').css("background","darkorchid");
                        } else {
                            $(".load-more-explainer").text("Ver mais");
                        }
                    }, 2000);


                }
            });
        } else {
            $('.load-more-explainer').text("Carregando...");

            // Setting little delay while removing contents
            setTimeout(function () {

                // When row is greater than allcount then remove all class='post' element after 3 element
                $('.post-explainer:nth-child(3)').nextAll('.post-explainer').remove().fadeIn("slow");

                // Reset the value of row
                $("#row-explainer").val(0);

                // Change the text and background
                $('.load-more-explainer').text("Ver mais");
                $('.load-more-explainer').add('text-white btn-video');
            }, 2000);


        }

    });

});