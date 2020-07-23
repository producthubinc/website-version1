class Products {
  constructor(redirect) {
    this.Title = document.getElementById('product-title');
    this.Description = document.getElementById('product-description');
    this.Details = document.getElementById('product-details');
    this.Thumbnail = document.getElementById('product-thumbnail');

    this.selected = null;
    this.InputFileTypes = {
      Image: 'image/x-png, image/jpeg',
      Model: '.igs,.iges,.step,.stp,.stl,.obj'
    }
    this.Products = [
      {
        Title: 'LITHOPHANES',
        Name: 'Lithophane Keychain',
        Description: `Sometimes perspective necessitates technique!
        Lithophanes are unique in their own way. They preserve your memories to be recalled as and when you like.
        At Product Hub 3D we provide the best quality personalized lithophanes in different sizes and shapes.`,
        Details: [
          'Lithophane Keychain',
          'Rs. 299/-',
          'Size: Approx. 45mm X 65mm X 5mm',
          '(sizes may vary depending on picture)',
          'Supported File Types: .png, .jpg, .jpeg'
        ],
        image: '/img/litho.jpeg',
        Price: 299,
        FileFormat: this.InputFileTypes.Image,

      },
      {
        Title: 'FRAMES',
        Name: 'Lithophane Frame',
        Description: `Grab one for your beloved ones.`,
        Details: [
          'Lithophane Frame',
          'Rs. 799/-',
          'Size: Approx. 45mm X 65mm X 5mm',
          '(sizes may vary depending on picture)',
          'Supported File Types: .png, .jpg, .jpeg'
        ],
        image: '/img/frame.jpeg',
        Price: 799,
        FileFormat: this.InputFileTypes.Image
      },
      {
        Title: 'Custom 3D Print',
        Name: 'Custom',
        Description: `Sometimes perspective necessitates technique!
        Lithophanes are unique in their own way. They preserve your memories to be recalled as and when you like.
        At Product Hub 3D we provide the best quality personalized lithophanes in different sizes and shapes.`,
        Details: [
          'Lithophane Keychain',
          `Price will be communicated via Email. 
          (Based on your model)`,
          'Size: Custom',
          'Supported File Types: .igs,.iges,.step,.stp,.stl,.obj'
        ],
        image: '/img/custom.jpeg',
        Price: 0,
        FileFormat: this.InputFileTypes.Model
      },

    ];
  }

  Handler(response) {
  }

  LoadProductOnPage() {
    if (!this.selected)
      return;

    this.Title.innerHTML = this.selected.Title;
    this.Description.innerHTML = this.selected.Description;
    this.Thumbnail.src = this.selected.image;
    this.Details.innerHTML = "";
    this.selected.Details.forEach((item) => {
      const listItem = document.createElement("li");
      listItem.innerHTML = item;
      this.Details.appendChild(listItem);
    });
  }

  load() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = parseInt(urlParams.get('id'));
    this.selected = this.Products[id - 1];
    this.LoadProductOnPage();
  }

}