
let _              = require("lodash"),
    fs             = require("fs"),
    path           = require("path"),
    url            = require("url"),
    sourceDir      = __dirname,
    harFile        = path.join(sourceDir, "data", "network-data.har"),
    harResultsFile = path.join(sourceDir, "data", "network-results.txt"),
    //                https?://js\w*\.?([\w]+\.?)*/[-+_=.?:,/%\w\d]*
    esriURLRegEx   = /https?:\/\/js\w*\.?([\w]+\.?)*\/[-+_=(.|\n)?:,\/%\w\d]*/im,
    //                https?://heb\.?([\w]+\.?)*/[-+_=.?:,/%\w\d]*
    localURLRegEx  = /https?:\/\/heb\.?([\w]+\.?)*\/[-+_=(.|\n)?:,\/%\w\d]*/im,
    //                https?://[a-zA-z0-9]+\.[a-zA-Z]+\.[a-zA-Z]+(/[a-zA-Z%20]*)*.*
    anyURLRegEx    = /https?:\/\/([\w]+\.?)*\/[-+_=(.|\n)?:,\/%\w\d]*/im,
    localURLs      = [],
    esriCDNURLs    = [],
    anyURLs        = [],
    brokenURLs     = [],
    urlStrings     = "";

/**
 * Sorts and flattens an array of URL objects
 * and returns an array of the URLs sorted.
 *
 * @param value - An array of URL objects
 * @returns flattenedUrls - An array of the the URLs sorted.
 *
 */
function sortThenNormalizeURLObjects(value){
  // sortBy hostname, then path
  let sortedURLs = _.sortBy(value, ["hostname", "path"]);
  let flattenedURLs = sortedURLs.map(function (item){
    // return href
    return item.href;
  });
  return flattenedURLs.join("\n");
}

console.log("Parsing HAR input: %s", harFile);

let rawHarData = fs.readFileSync(harFile, "utf-8");
let harData = JSON.parse(rawHarData).log;

harData.entries.forEach(function (harEntry){
  let harRequest = harEntry.request;
  let requestURL = harRequest.url;

  if (esriURLRegEx.test(requestURL)) {
    esriCDNURLs.push(url.parse(requestURL));
  }
  else if (localURLRegEx.test(requestURL)) {
    localURLs.push(url.parse(requestURL));
  }
  else if (anyURLRegEx.test(requestURL)) {
    anyURLs.push(url.parse(requestURL));
  }
  else {
    console.log(requestURL);
  }

  if (harEntry.response.status === 404) {
    brokenURLs.push(url.parse(requestURL));
  }
});

if (esriCDNURLs.length > 0) {
  urlStrings += "// Esri CDN URLs\n" + sortThenNormalizeURLObjects(esriCDNURLs);
}
if (localURLs.length > 0) {
  urlStrings += "\n// Application URLs\n" + sortThenNormalizeURLObjects(localURLs);
}
if (anyURLs.length > 0) {
  urlStrings += "\n// Other URLs\n" + sortThenNormalizeURLObjects(anyURLs);
}
if (brokenURLs.length > 0) {
  urlStrings += "\n// Broken URLs\n" + sortThenNormalizeURLObjects(brokenURLs);
}

fs.writeFileSync(harResultsFile, urlStrings, "utf-8");

console.log("Saving HAR output: %s", harResultsFile);