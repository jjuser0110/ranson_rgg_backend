$(function(e) {
	
	$('#example').DataTable(
		{
			scrollX: true,
         	autoWidth: false 
		});
	$('#example2').DataTable(
		{
			scrollX: true,
         	autoWidth: false 
		}
	);
	$('#example3').DataTable({
		scrollX: true,
         	autoWidth: false ,
			 order: [[3, 'asc']]
	});
	$('#example4').DataTable({
		scrollX: true,
         	autoWidth: false ,
			 order: [[4, 'desc']]
	});
	$('#example5').DataTable({
		scrollX: true,
         	autoWidth: false ,
			 order: [[3, 'desc']]
	});
	$('#example6').DataTable({
		scrollX: true,
         	autoWidth: false ,
			 order: [[2, 'desc']]
	});
	$('#example7').DataTable({
		scrollX: true,
		autoWidth: false ,
		order: [[1, 'desc']]
	});
	
	$('#example8').DataTable({
		scrollX: true,
		autoWidth: false,
		order: [[0, 'desc']]
	});
	
	$('#example9').DataTable({
		scrollX: true,
		autoWidth: false,
		order: [[0, 'desc']]
	});
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
		$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
	});
	
} );
