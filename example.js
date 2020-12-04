$.get('/support.tallyfy.HAR')
	.done(data => {
console.log(data);
const parseData= JSON.parse(data);
console.log(parseData.name);

	})