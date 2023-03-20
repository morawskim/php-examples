.PHONY: compile-mjml-template
compile-mjml-template:
	npx mjml templates/example.mjml -o templates/example.html.twig

.PHONY: test
test: compile-mjml-template
	php ./demo.php
