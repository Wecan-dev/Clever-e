      $(document).ready(function() {
       
        $(".lang-item").html(function(serachreplace, replace) {
        return replace.replace('Español', 'ESP/');
        });

        $(".lang-item").html(function(serachreplace, replace) {
        return replace.replace('English', 'ENG');
        });          

    });