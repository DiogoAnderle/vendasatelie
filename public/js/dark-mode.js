const currentTheme = localStorage.getItem('theme');

if (currentTheme === 'dark') {
    $("#body").addClass("dark-mode")
    $("#dark-icon").html('<i class="fas fa-moon animate__flipInX"></i>')
} else {
    $("#body").removeClass("dark-mode")
    $("#dark-icon").html('<i class="fas fa-solid fa-sun"></i>')
}

$("#dark-mode").click(function () {
    if ($("input#dark-mode").is(':checked')) {
        $("#body").addClass("dark-mode")
        $("#dark-icon").html('<i class="fas fa-moon animate__flipInX"></i>')
        localStorage.setItem('theme', 'dark')
    } else {
        $("#body").removeClass("dark-mode")
        $("#dark-icon").html('<i class="fas fa-solid fa-sun"></i>')
        localStorage.setItem('theme', 'light')
    }
})
