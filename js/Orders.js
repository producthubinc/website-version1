class Orders {
  constructor(redirect) {

    this.Summary = document.getElementById('summary');
    this.Name = document.getElementById('summary-product');
    this.Quantity = document.getElementById('summary-quantity');
    this.Amount = document.getElementById('summary-amount');
    this.File = document.getElementById('summary-file');
    this.PaymentMode = document.getElementById('summary-paymode');
    this.Address = document.getElementById('summary-address');
    this.ImageView = document.getElementById('ImageView');
    this.SupportedFormats = document.getElementById('supported-formats');
    ///FORM
    this.FileInput = document.getElementById('upload');
    this.QuantityInput = document.getElementById('quantity');
    this.PayModeInput = document.getElementById('payment');
    this.AddressInput = document.getElementById('address');
    this.ReviewButton = document.getElementById('review-btn');

    this.params = [];

    this.Request = 'getaddress';
    let url = "../php/main.php?request=getaddress";
    ajax_get(url, this);
  }


  Handler(response) {
    const res = JSON.parse(response);
    if(this.Request == 'getaddress')
    {
      this.AddressInput.value = res.Content;
      this.Request = null;
    }
  }

  placeOrder(id) {
    window.location = '/order.html?id=' + id;
  }

  ResetBorders() {
    this.FileInput.parentElement.style.border = 'none';
    this.QuantityInput.parentElement.style.border = 'none';
    this.PayModeInput.parentElement.style.border = 'none';
  }

  ShowError(field) {
    this.ResetBorders();
    field.parentElement.style.border = "2px solid #EF5350";
  }

  Validate() {
    if (!this.FileInput.value) {
      this.ShowError(this.FileInput);
      return false;
    }
    if (!this.QuantityInput.value)
      return false;

    if (!this.PayModeInput.value)
      return false;

    return true;
  }

  ToggleForm() {
    if (this.Summary.style.visibility == 'visible')
      this.Summary.style.visibility = 'hidden';
    else
      this.Summary.style.visibility = 'visible';
    this.FileInput.disabled = !this.FileInput.disabled;
    this.QuantityInput.disabled = !this.QuantityInput.disabled;
    this.PayModeInput.disabled = !this.PayModeInput.disabled;
    this.AddressInput.disabled = !this.AddressInput.disabled;
    this.ReviewButton.disabled = !this.ReviewButton.disabled;
  }

  SetFileFilter(filter) {
    this.FileInput.setAttribute('accept', filter);
    if (this.FileInput.accept.includes('image'))
      this.ImageView.style.display = 'block';
    else
      this.ImageView.style.display = 'none';
      //this.SupportedFormats.innerHTML = filter;
  }

  edit() {
    this.ToggleForm();
  }

  review(product) {
    if (!product)
      return;

    if (!this.Validate()) {
      return;
    }

    this.ToggleForm();

    //Create Review Order Component
    this.Name.innerHTML = product.Name;
    this.Quantity.innerHTML = this.QuantityInput.value;
    if (product.Price !== 0) {
      this.Amount.innerHTML = 'Rs. ';
      this.Amount.innerHTML += this.QuantityInput.value * product.Price;
      this.Amount.innerHTML += ' /-';
    }
    else {
      this.Amount.innerHTML = 'Amount will be communicated via Email based on your model.';
    }

    let file = this.FileInput.value.replace('/', '\\');
    file = file.split('\\');
    file = file[file.length - 1];
    this.File.innerHTML = file;
    this.PaymentMode.innerHTML = this.PayModeInput.value;
    this.Address.innerHTML = this.AddressInput.value;
  }

  confirm() {
    const ConfirmButton = document.getElementById('confirmbtn');
    ConfirmButton.disabled = true;
    const EditButton = document.getElementById('editbtn');
    EditButton.disabled = true;

    const File = this.FileInput;
    const Quantity = this.QuantityInput.value;
    const PaymentMode = this.PayModeInput.value;
    const Address = this.AddressInput.value;
    const Amount = this.Amount.innerHTML;
    var formData = new FormData();

    if (File.files && File.files.length == 1) {
      var file = File.files[0]
      formData.set("file", file, file.name);
    }
    
    formData.set("Quantity", Quantity);
    formData.set("PaymentMode", PaymentMode);
    formData.set("Amount", Amount);
    formData.set("Address", Address);
    formData.set("request", "placeorder");

    // Http Request  
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          var response = this.responseText;
        alert("Your order will be confirmed via Email soon.\n Please check your mailbox.");
        window.location.replace('/');
      }
    }
    request.open('POST', "/php/main.php");
    request.send(formData);
  }
}