var model;

async function loadModel() {
  model = await tf.loadLayersModel("TFJS/model.json");
}

function predictImage() {
  let image = cv.imread(canvas);
  cv.cvtColor(image, image, cv.COLOR_RGBA2GRAY, 0);
  cv.threshold(image, image, 175, 255, cv.THRESH_BINARY);

  let contours = new cv.MatVector();
  let hierarchy = new cv.Mat();
  // You can try more different parameters
  cv.findContours(
    image,
    contours,
    hierarchy,
    cv.RETR_EXTERNAL,
    cv.CHAIN_APPROX_SIMPLE
  );

  let outputArr = [];

  for (let i = contours.size() - 1; i >= 0; i--) {
    let temp = [];

    let cnt = contours.get(i);
    let rect = cv.boundingRect(cnt);

    let digit = image.roi(rect);

    var height = digit.rows;
    var width = digit.cols;

    if (height > width) {
      height = 20;
      const scaleFactor = digit.rows / height;
      width = Math.round(digit.cols / scaleFactor);
    } else {
      width = 20;
      const scaleFactor = digit.cols / width;
      height = Math.round(digit.rows / scaleFactor);
    }

    let newSize = new cv.Size(width, height);
    cv.resize(digit, digit, newSize, 0, 0, cv.INTER_AREA);

    const LEFT = Math.ceil(4 + (20 - width) / 2);
    const RIGHT = Math.floor(4 + (20 - width) / 2);
    const TOP = Math.ceil(4 + (20 - height) / 2);
    const BOTTOM = Math.floor(4 + (20 - height) / 2);

    const BLACK = new cv.Scalar(0, 0, 0, 0);
    cv.copyMakeBorder(
      digit,
      digit,
      TOP,
      BOTTOM,
      LEFT,
      RIGHT,
      cv.BORDER_CONSTANT,
      BLACK
    );

    let pixelValues = digit.data;
    pixelValues = Float32Array.from(pixelValues);
    pixelValues = pixelValues.map(function (item) {
      return item / 255.0;
    });

    const X = tf.tensor([pixelValues]);

    const result = model.predict(X);
    const resultArr = result.dataSync();

    temp.push(resultArr.indexOf(Math.max(...resultArr)));
    temp.push(rect.x);
    outputArr.push(temp);
  }

  //Sorting the digits in order (left to right)
  outputArr.sort((a, b) => {
    return a[1] - b[1];
  });

  let output = "";
  console.log(outputArr);
  for (let i = 0; i < outputArr.length; i++) {
    output += outputArr[i][0].toString();
  }

  // Testing Only (delete later)
  //   const outputCanvas = document.createElement("CANVAS");
  //   cv.imshow(outputCanvas, image);
  //   document.body.appendChild(outputCanvas);

  // Cleanup
  image.delete();
  contours.delete();
  hierarchy.delete();

  return parseInt(output);
}
