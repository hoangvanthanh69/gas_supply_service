var country_arr = new Array("Cần Thơ");
var s_a = new Array();
s_a[0] = "";
s_a[1] = "Ninh Kiều|Cái Răng|Bình Thủy|Ô Môn|Phong Điền|Thốt Nốt|Cờ Đỏ|Vĩnh Thạnh|Thới Lai"; // Cần Thơ

var s_b = new Array();
s_b[1, 1] = "Cái Khế|Xuân Khánh|Hưng Lợi|An Hòa|Thới Bình|An Nghiệp|An Cư|Tân An|An Phú|An Khánh"; // ninh kiều
s_b[1, 2] = "Lê Bình|Hưng Phú|Hưng Thạnh|Ba Láng|Thường Thạnh|Phú Thứ|Tân Phú" // cái răng
s_b[1, 3] = "Bình Thủy|Trà An|Trà Nóc|An Đông|An Thới|Bùi Hữu Nghĩa|Long Hòa|Long Tuyền" // bình thủy
s_b[1, 4] = "Châu Văn Liêm|Thới Hòa|Thới Long|Long Hưng|Thới An|Phước Thới|Trường Lạc" // ổ môn
s_b[1, 5] = "Giai Xuân|Mỹ Khánh| Nhơn Ái| Nhơn Nghĩa| Tân Thới| Trường Long" // Phong Điền
s_b[1, 6] = "Thới Thuận|Trung Nhứt|Trung Kiên|Thuận Hưng|Tân Hưng|Tân Lộc|thị trấn Thốt Nốt" // Thốt Nốt
s_b[1, 7] = "Trung An| Trung Thạnh| Thạnh Phú| Trung Hưng|Thị trấn Cờ Đỏ| Thới Hưng| Đông Hiệp| Đông Thắng| Thới Đông| Thới Xuân" // Cờ Đỏ
s_b[1, 8] = "Thạnh An|Thạnh Lộc|Thạnh Lợi|Thạnh Mỹ|Thạnh Quới|Thạnh Thắng|Thạnh Tiến|Vĩnh Bình|Vĩnh Trinh" // Vĩnh Thạnh
s_b[1, 9] = "Định Môn|Đông Bình|Đông Thuận|Tân Thạnh|Thới Tân|Thới Thạnh|Trường Thắng|Trường Thành|Trường Xuân|Trường Xuân A|Trường Xuân B|Xuân Thắng" // Thới Lai






function print_country(country_id) {
  var option_str = document.getElementById(country_id);
  option_str.length = 0;
  option_str.options[0] = new Option('Chọn Tỉnh/TP', '');
  option_str.selectedIndex = 0;
  for (var i = 0; i < country_arr.length; i++) {
    option_str.options[option_str.length] = new Option(country_arr[i], country_arr[i]);
  }
}

function print_state(state_id, state_index) {
  var option_str = document.getElementById(state_id);
  option_str.length = 0;
  option_str.options[0] = new Option('Chọn Quận/Huyện', '');
  option_str.selectedIndex = 0;
  var state_arr = s_a[state_index].split("|");
  for (var i = 0; i < state_arr.length; i++) {
    option_str.options[option_str.length] = new Option(state_arr[i], state_arr[i]);
  }
}
function print_district(district_id, district_index) {
  var option_str = document.getElementById(district_id);
  option_str.length = 0;
  option_str.options[0] = new Option('Chọn Phường/Xã', '');
  option_str.selectedIndex = 0;
  var district_arr = s_b[district_index].split("|");
  for (var i = 0; i < district_arr.length; i++) {
    option_str.options[option_str.length] = new Option(district_arr[i], district_arr[i]);
  }
}

function print_product(product_id, product_index) {
  var option_str = document.getElementById(product_id);
  option_str.length = 0;
  option_str.options[0] = new Option('Chọn Sản Phẩm', '');
  option_str.selectedIndex = 0;
  var product_arr = s_a[product_index].split("|");
  for (var i = 0; i < product_arr.length; i++) {
    option_str.options[option_str.length] = new Option(product_arr[i], product_arr[i]);
  }
}
// search 
var element_column = document.querySelectorAll('.element_column');
var search_item = document.getElementById('search_item');
  search_item.addEventListener('keyup',searchItem);
  function searchItem(){
    let valueItem = search_item.value.toLowerCase();
    Array.from(element_column).forEach(function(ele){
      let nameItem = ele.querySelector('.infor').firstElementChild.textContent;
      if(nameItem.toLowerCase().indexOf(valueItem) !== -1){
        ele.style.display = 'block';
      }
      else{
        ele.style.display = 'none';
      }
    })
    checkEmpty(element_column);
  }
  function checkEmpty(element){
    let count = 0;
    for(let i=0; i<element.length; i++){
      if(element[i].style.display === 'flex'){
        count++;
      }
    }
    if(count === 0 ){
      document,querySelector('#showtext').textContent = 'không có sản phảm';
    }
    else{
      document,querySelector('#showtext').textContent = '';
    }
  }

  function fillAddressFields() {
    var address = document.querySelector('.delivery-location span').textContent.split(', ');
    var country = address[0];
    var state = address[1];
    var district = address[2];
    var diachi = address[3];

    document.querySelector('#country').value = country;
    print_state('state', document.querySelector('#country').selectedIndex);
    document.querySelector('#state').value = state;
    print_district('district', document.querySelector('#state').selectedIndex);
    document.querySelector('#district').value = district;
    document.querySelector('#exampleFormControlInput1').value = diachi;
  }

  document.getElementById("address").onchange = function() {
    var country = document.getElementById("country").value;
    var state = document.getElementById("state").value;
    var district = document.getElementById("district").value;
    var diachi = document.getElementById("exampleFormControlInput1").value;
    document.querySelector(".delivery-location span").innerHTML = country + ", " + state + ", " + district + ", " + diachi;
  }
  document.querySelector('.submit').addEventListener('click', function() {
    fillAddressFields();
  });

  document.getElementById("change-address").addEventListener("click", function() {
    var selectAddressUser = document.querySelector(".select-address-user");
    document.querySelector('.select-address-user').style.display = 'block';
    if (selectAddressUser.classList.contains("hidden")) {
      selectAddressUser.classList.remove("hidden");
    } else {
      selectAddressUser.classList.add("hidden");
    }
  });
  