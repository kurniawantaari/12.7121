    var tempat = "di Indonesia";
    var locations = "Indonesia";
    $("#selectProvinces").change(function () {
        if ($("#selectProvinces").val() != "")
        {
            $("#selectKabupaten").attr("disabled", false);
            locations = "Propinsi";
            tempat = "di Propinsi " + $("#selectProvinces option:selected").text() + ", Indonesia";
        } else
        {
            $("#selectKabupaten").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kabupaten/Kota-</option>");
            var tempat = "di Indonesia";
            var locations = "Indonesia";
        }
    });
    $("#selectKabupaten").change(function () {

        if ($("#selectKabupaten").val() != "") {
            $("#selectKecamatan").attr("disabled", false);
            locations = "Kabupaten";
            tempat = "di Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            $("#selectKecamatan").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kecamatan-</option>");
            locations = "Propinsi";
            tempat = "di Propinsi " + $("#selectProvinces option:selected").text() + ", Indonesia";
        }
    });
    $("#selectKecamatan").change(function () {
        if ($("#selectKecamatan").val() != "") {
            $("#selectDesa").attr("disabled", false);
            locations = "Kecamatan";
            tempat = "di Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            $("#selectDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
            locations = "Kabupaten";
            tempat = "di Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        }
    });
    $("#selectDesa").change(function () {
        if ($("#selectDesa").val() != "") {
            locations = "Desa";
            tempat = "di Desa " + $("#selectDesa option:selected").text()
                    + ", Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            locations = "Kecamatan";
            tempat = "di Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        }
    });