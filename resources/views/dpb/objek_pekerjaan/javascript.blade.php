<script>
    $('.organization').select2({
        placeholder: "Please Select...",
        width: "100%",
        minimumInputLength: 2,
        ajax: {
            url: "{{url('select-filter/ajax_organisasi')}}",
            dataType: 'json',
            data: function(params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $(function() {
        $(":radio.is_objek_pekerjaan_alias").click(function() {
            if ($(this).val() == 1) {
                $("#display_objek_pekerjaan_alias").show();
                $("#objek_pekerjaan_alias").prop('required', true);
            } else {
                $("#display_objek_pekerjaan_alias").hide();
                $("#objek_pekerjaan_alias").removeAttr('required');
            }
        })
    });

    function delete_objek_pekerjaan(id) {
        if (confirm('Anda akan menghapus data ini ?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('dpb/delete-objek-pekerjaan')}}/" + id,
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

@foreach(DB::select("SELECT *, (SELECT branch_name FROM branch_agency WHERE id_branch_agency =
objek_pekerjaan.organization) AS nama_organisasi
FROM objek_pekerjaan WHERE id_dpb = $id") as $row)
<script>
    $(document).ready(function() {
        $("#organization{{$row->id_objek_pekerjaan}}").append($("<option selected='selected'></option>").val(
            '{{$row->id_objek_pekerjaan}}').text('{{$row->nama_organisasi}}')).trigger('change');
    });
</script>
@endforeach