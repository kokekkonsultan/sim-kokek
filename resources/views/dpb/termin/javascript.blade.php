<script>
    $("#persentase_pembayaran").keyup(function() {
        var nilai_pekerjaan = "{{$dpb->nilai_pekerjaan}}";
        var persen = $("#persentase_pembayaran").val();
        var total = (persen / 100) * nilai_pekerjaan;

        $("#harga_pembayaran").val(new Intl.NumberFormat(["ban", "id"]).format(total));
    });


    function delete_termin(id) {
        if (confirm('Anda akan menghapus data ini ?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('dpb/delete-termin')}}/" + id,
                dataType: "JSON",
                success: function(data) {
                    if (data.status === true) {
                        Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }

                    if (data.status === false) {
                        Swal.fire('Error', 'Tidak dapat menghapus data!', 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }
</script>
