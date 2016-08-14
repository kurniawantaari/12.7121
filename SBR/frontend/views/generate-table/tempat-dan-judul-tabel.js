//    var attributes=false;
//    var years=false;
//    $("#selectAttributes").change(function () {
//    if($(this).val().length>1){attributes=true;}else{attributes=false;}});
//    $("#selectYears").change(function () {
//    if($(this).val().length>1){years=true;}else{years=false;}});

    $("#selectProvinces").change(function () {
        if ($("#selectProvinces").val() != "")
        {
            vartempat = "Propinsi";
            tempat = "di Propinsi " + $("#selectProvinces option:selected").text() + ", Indonesia";
        } else
        {
            tempat = "di Indonesia";
            vartempat = "Indonesia";
        }
    });
    $("#selectKabupaten").change(function () {

        if ($("#selectKabupaten").val() != "") {
            vartempat = "Kabupaten";
            tempat = "di Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            vartempat = "Propinsi";
            tempat = "di Propinsi " + $("#selectProvinces option:selected").text() + ", Indonesia";
        }
    });
    $("#selectKecamatan").change(function () {
        if ($("#selectKecamatan").val() != "") {
            vartempat = "Kecamatan";
            tempat = "di Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            vartempat = "Kabupaten";
            tempat = "di Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        }
    });
    $("#selectDesa").change(function () {
        if ($("#selectDesa").val() != "") {
            vartempat = "Desa";
            tempat = "di Desa " + $("#selectDesa option:selected").text()
                    + ", Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            vartempat = "Kecamatan";
            tempat = "di Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        }
    });