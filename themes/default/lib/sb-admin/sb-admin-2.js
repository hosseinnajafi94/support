$(function () {
    $('#side-menu').metisMenu();
});
$(function () {
    var url = window.location.toString();
    var urls = url.split('?');
    url = urls[0];
    var element = $('ul.nav a').filter(function () {
        return this.href === url;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
    if (element.parent().hasClass('nav-second-level')) {
        element.parent().addClass('in').parent().addClass('active');
    }
});