/* Script for the profile table */
jQuery(document).ready(function($) {
    
    var educationVal = $('#education-dropdown'),
        skillsvl = $('#skills-dropdown');
    
    $(educationVal).chosen();
    $(educationVal).on("change", function() {
        $(this).trigger("chosen:updated");
    });

    $(skillsvl).chosen();
    $(skillsvl).on("change", function() {
        $(this).trigger("chosen:updated");
    });

    var slider = document.getElementById('myRange');
    var rangeValue = document.getElementById('rangeValue');

    slider.addEventListener('input', function() {
        rangeValue.textContent = slider.value;
    });
    
    /** Pagination */
    $('.ajax-paginate').click(function(e){
        e.preventDefault();
        var offset = this.getAttribute('data-page'),
            nonce = $('#profile_lists_nonce').val();

            $('.ajax-paginate').removeClass('active');
            $(this).addClass('active');
            offset = (offset - 1) * 5;

        $.ajax({
            url: profile_lists_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'profile_lists_filter_posts',
                nonce: nonce,
                offset: offset
            },
            success: function(response) {
                $('.profile-table').html(response.data);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })

    /** Short the table */
    $('.short').click(function(){
        var shortVal = 'DESE',
            nonce = $('#profile_lists_nonce').val();

            $.ajax({
                url: profile_lists_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'profile_lists_filter_posts',
                    nonce: nonce,
                    shortVal: shortVal
                },
                success: function(response) {
                    $('.profile-table').html(response.data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
    })

    /** Ajax FIlter */
    $('#filter-button').click(function() {
        var rating = $('#rating-select').val(),
            jobsCompleted = $('#jobs-completed-select').val(),
            experience = $('#experience').val(),
            age = $('#myRange').val(),
            skills = $('#skills-dropdown').val(),
            education = $('#education-dropdown').val(),
            title = $('#title').val(),
            nonce = $('#profile_lists_nonce').val();

        
        $.ajax({
            url: profile_lists_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'profile_lists_filter_posts',
                rating: rating,
                jobsCompleted: jobsCompleted,
                experience: experience,
                age: age,
                skills: skills,
                education: education,
                title: title,
                nonce: nonce
            },
            success: function(response) {
                $('.profile-table').html(response.data);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});