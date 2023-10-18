const express = require('express');
const app = express();
const csvJson = require("csvtojson");
const csvFilePath = 'Mobile_Food_Facility_Permit.csv';

app.use(express.static(__dirname + '/public'));
app.use(express.json());

app.post('/api', async function (req, res) {
  const params = req.body;
  console.log('method:' + params.method);
  const csvObj = csvJson();
  const csvData = await csvObj.fromFile(csvFilePath);
  // route process
  const data = routeHandle(params, csvObj, csvData);
  // return response
  if (data) {
    res.json(data);
  } else {
    res.status(400).json({ message: 'unknown method' });
  }

});

function routeHandle(params, csvObj, csvData) {
  let data = false;
  if (params.method == 'Status') {
    data = ['APPROVED', 'REQUESTED', 'EXPIRED', 'ISSUED'];
  } else if (params.method == 'header') {
    data = csvObj.parseRuntime.headers;
  } else if (params.method == 'allData') {
    data = csvData;
  } else if (params.method == 'filterData') {
    let filterArray = [];
    if (params.filter) {
      csvData.forEach((item) => {
        if (item.FoodItems && item.FoodItems.toLowerCase().indexOf(params.filter.toLowerCase()) >= 0) {
          filterArray.push(item);
        }
      });
    } else {
      filterArray = csvData;
    }
    data = filterArray;
  }
  return data;
}

app.listen(3000, (err) => {
  if (err) {
    return console.log('something bad happened', err);
  }
  console.log(`server is listening on 3000 port`);
});