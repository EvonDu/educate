//去除新版本JQ没有getResponseHeader函数的问题
$(document).ajaxComplete(function (event, xhr, settings) {
    xhr.getResponseHeader = function (string) {
        return false;
    }
})