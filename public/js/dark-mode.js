const currentTheme = localStorage.getItem('theme');

if (currentTheme === 'dark') {
    $("#body").addClass("dark-mode")
    $("#dark-icon").html('<i class="fas fa-moon"></i>')
} else {
    $("#body").removeClass("dark-mode")
    $("#dark-icon").html('<i class="fas fa-solid fa-sun"></i>')
    const elements = $('.userdata').toArray();
    for (const element of elements) {
      $(element).removeClass('text-white');
      $(element).addClass('text-dark');
    }
}

$("#dark-mode").click(function () {
    if ($("input#dark-mode").is(':checked')) {
        $("#body").addClass("dark-mode")
        $("#dark-icon").html('<i class="fas fa-moon"></i>')
        localStorage.setItem('theme', 'dark')
    } else {
        $("#body").removeClass("dark-mode")
        $("#dark-icon").html('<i class="fas fa-solid fa-sun"></i>')
        localStorage.setItem('theme', 'light')
        const elements = $('.userdata').toArray();
        for (const element of elements) {
          $(element).removeClass('text-white');
          $(element).addClass('text-dark');
        }
        
    }
})
