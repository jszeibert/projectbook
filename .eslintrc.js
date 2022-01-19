module.exports = {
	globals: {
		t: false,
		n: false,
		OC: false,
		OCA: false,
		appVersion: true,
	},
	extends: [
		'@nextcloud',
	],
	rules: {
		'jsdoc/require-param-description': ['off'],
		'jsdoc/require-param-type': ['off'],
		'jsdoc/check-param-names': ['off'],
		'jsdoc/no-undefined-types': ['off'],
		'jsdoc/require-property-description' : ['off']
	},
}