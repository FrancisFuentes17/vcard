function generateVCard(cardNo, acct) {
    
    var inputs = {
        "cardNo" : cardNo,
        "acct" : acct
    };

    showPLoader();
    setTimeout(function() {
        $.ajax({
            url : main.baseURL + "/api/generate",
            type : "post",
            data : JSON.stringify(inputs),
            dataType : "json",
            contentType : "application/json; charset=utf-8",
            success: function (data) {

                var vcard = "";

                if(data.status=="Success") {

                    var fcClass = "member-info white";
                    var fcInfo = '<h2 id="card-number">'+ data.cardNo +'</h2>' + 
                    '<h3 id="member-name">'+ data.memberName +'</h3>' + 
                    '<h3 id="deployment">'+ data.company +'</h3>';
                    var qrClass = "qrcode-container";
                    var cardNote = "This serves as your virtual card to be presented at any of IMS-ANEC business partners nationwide.";

                    if(data.acct == "IWC") {
                        fcClass = "member-info-iwc black";
                        fcInfo = '<h2 id="card-number">'+ data.memberName +'</h2>' + 
                        '<h3 id="member-name">'+ data.company +'</h3>' + 
                        '<h2 id="deployment">'+ data.cardNo +'</h2>';
                        qrClass = "qrcode-container-iwc";
                        var cardNote = "This serves as your virtual card to be presented at any of IWC owned or accredited hospitals and clinics.";
                    }
                    
                    vcard = '<div class="flip-card">' +
                        '<div class="flip-card-inner">' +
                            '<div class="flip-card-front">' +
                                '<div class="'+ fcClass +'">' + fcInfo + '</div>' +
                                '<div class="'+ qrClass +'"><div id="qrcode"></div></div>' +
                                '<img id="card-front-image" src="src/images/'+ data.cardFront +'" >' +
                            '</div>' +
                            '<div class="flip-card-back">' +
                                '<img id="card-back-image" src="src/images/'+ data.cardBack +'" >' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="card-notes">' +
                        '<div class="mr-auto">' +
                            '<span class="text-danger">***</span>' + cardNote +
                            '<div class="mt-3">' +
                                '<button type="button" class="btn btn-outline-secondary btn-sm" onClick="flip()">' +
                                    'Flip VCard' +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

                    $(".vcard").html(vcard);
                    
                    data.qrData != "" && generateQRCode(data.qrData, data.acct);
                    
                } else {
                    
                    vcard = '<div class="flip-card"><div class="error">'+data.feedback+'</b></div></div>';
                    $(".vcard").html(vcard);
                }
            
                $(".vcard").fadeIn();
                hidePLoader();
            }
        });
    }, main.delay);
}

function flip() {
    $('.flip-card-inner').toggleClass('flipped');
}

$.validator.setDefaults({
    submitHandler: function() {

        var cardNo = $("#email").val();
        var acct = "IMS";

        generateVCard(cardNo, acct);
        
    }
});

$("#frmGenerate").validate(validationRules);

function btnLoader(show, btnID) {
    if(show==true) {
        var spinner = "<span class='spinner-border spinner-border-sm text-light mr-2' role='status' aria-hidden='true'></span> ";
        spinner = spinner + "Generate";
        $(btnID).prop("disabled", true);
    } else {
        $(btnID).prop("disabled", false);
    }
}

function generateQRCode(data, acct) {
    
    $('#qrcode').empty();

    var QR_CODE = new QRCode("qrcode", {
        width: 70,
        height: 70,
        colorDark: acct == "IMS" ? "#fff" : "#000",
        colorLight: acct == "IMS" ? "#000" : "#fff",
        correctLevel: QRCode.CorrectLevel.H
    });

    QR_CODE.makeCode(data);
}

function showPLoader() {
    $("#overlay").show();
}

function hidePLoader() {
    $("#overlay").hide();
}


