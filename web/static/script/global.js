$("a[rel=tooltip]").tooltip({trigger: "hover", html: true, placement: "top"});
$("a[rel=popover]").popover({trigger: "hover", html: true, placement: "top"});
$("a[rel=popover-click]").popover({html: true, placement: "top"}).show();
$('a[href=#]').click(function (e) {
    e.preventDefault()
});
