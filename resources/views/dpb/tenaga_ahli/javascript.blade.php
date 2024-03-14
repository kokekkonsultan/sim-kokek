<script>
$('#id_tenaga_ahli').select2({
    placeholder: "Please Select",
    width: '100%'
});

function delete_tenaga_ahli(id) {
    if (confirm('Anda akan menghapus data ini ?')) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{url('dpb/delete-tenaga-ahli')}}/" + id,
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