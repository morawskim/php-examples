const AWS = require('aws-sdk');
// Uzywamy uslugi S3, wiec nasza funkcja musi miec przypisana odpowiednia role
const s3 = new AWS.S3()

exports.handler = async function(event) {
  return {
      statusCode: 200,
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({
        "requestEvent": event,
        "buckets": await s3.listBuckets().promise()
      }),
  };
}
