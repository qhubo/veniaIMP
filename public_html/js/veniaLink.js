function date_time() {
  $(".datepicker").datepicker();
  $(".datepicker_bottom").datepicker({ orientation: "bottom" });
  $(".timepicker").timepicker({ dynamic: true });
}
function select2() {
  $(".select2").select2();
}
date_time();
select2();
