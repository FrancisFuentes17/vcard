
var d = new Date(),
n = d.getMonth()  + 1,
y = d.getFullYear();

var main = {
    baseURL: "https://vcard.iwcsrvr.com",
    currentDate: d,
    currentMonth: n,
    currentYear: y,
    delay: 300 //3 Miliseconds
};

var validationRules = {
    errorElement: "em",
    errorPlacement: function ( error, element ) {
        error.addClass( "invalid-feedback" );
    },
    highlight: function ( element, errorClass, validClass ) {
        $( element ).addClass( "is-invalid" );
    },
    unhighlight: function (element, errorClass, validClass) {
        $( element ).removeClass( "is-invalid" );
    }
}