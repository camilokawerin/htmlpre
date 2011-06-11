<?php

$code = '<p>hello world</p>';
if (isset($_POST['code']) && $_POST['code'] != '') {
	$code = $_POST['code'];
}
if (preg_match_all('/<(.+?)>/s', $code, $match)) {
	$tags = $match[0];
	$elem = $match[1];
	$_code = '';
	foreach (preg_split('/<(.+?)>/s', $code) as $i => $text) {
		$tag = '';
		if (isset($tags[$i])) {
			$tag = htmlspecialchars($tags[$i], ENT_NOQUOTES);
			$class = '';
			if (preg_match('/(style|script)/si', $elem[$i], $match)) {
				$class = ' class="' . $match[0] . '"';
			} else {
				$tag = preg_replace('/(?<= )([a-z]+)(?==)/si', '<i>$1</i>', $tag);
				if (preg_match_all('/"(.*?)"/s', $tag, $match)) {
					$values = $match[0];
					$_tag = '';
					foreach (preg_split('/"(.*?)"/s', $tag) as $y => $attr) {
						$_tag .= $attr . (isset($values[$y]) ? '<b>' . $values[$y] . '</b>' : '');
					}
					$tag = $_tag;
				}
			}
			$tag = '<span' . $class . '>' . $tag . '</span>';
		}
		$_code .= $text . $tag;
	}
} else {
	$_code = $code;
}
if (isset($_POST['ajax'])) {
	header('Content-type: application/xml');
?>
<?xml version="1.0" encoding="utf-8"?>
<response>
	<code><?php echo htmlspecialchars($_code) . "\n" ?></code>
	<result><![CDATA[<?php echo $_code ?>]]></result>
</response>
<?php
	exit;
}
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <title>HTML prezr - convert code to entities with highlighted syntax</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
<article>
<header>
<h1>HTML pre<i>zr</i></h1>
<p>Convert your <abbr title="HyperText Markup Language">HTML</abbr> to entities, copy the returned code and paste it between <code><span>&lt;pre&gt;</span><span>&lt;/pre&gt;</span></code>. Add the style to your <abbr title="Cascade Style Sheet">CSS</abbr> for highlight the syntax.</p>
</header>

<form action="index.php" method="post">
<fieldset>
	<legend>Paste your code here</legend>
	<textarea name="code" id="code" cols="10" rows="5"><?php echo htmlspecialchars($code) ?></textarea>
	<button type="submit">Enjoy!</button>
</fieldset>
</form>

<section>
<h2>The code</h2>
<pre>
<span>&lt;html&gt;</span>
<textarea id="_code" cols="10" rows="5"><?php echo htmlspecialchars($_code) . "\n" ?></textarea>
<span>&lt;/html&gt;</span>
</pre>
</section>

<section>
<h2>The result</h2>
<pre id="result">
<?php echo $_code ?>
</pre>
</section>

<section>
<h2>The style</h2>
<pre>
<span class="style">&lt;style&gt;</span>
<textarea cols="10" rows="5">
span {
	color: #0000ff;
}
.script, .style {
	color: #800080;
}
b {
	color: #008080;
}
i {
	color: #000080;
	font-style: normal;
}
</textarea>
<span class="style">&lt;/style&gt;</span>
</pre>
</section>

<footer>
	<h2>Credits</h2>
	<p>Created by <a href="http://kawerin.com.ar">Camilo Kawerín</a> from <a href="http://convistaalmar.com.ar/">Con Vista Al Mar</a> in June 2011.</p>
	<pre class="unlicense">
	This is free and unencumbered software released into the public domain.

	Anyone is free to copy, modify, publish, use, compile, sell, or
	distribute this software, either in source code form or as a compiled
	binary, for any purpose, commercial or non-commercial, and by any
	means.

	In jurisdictions that recognize copyright laws, the author or authors
	of this software dedicate any and all copyright interest in the
	software to the public domain. We make this dedication for the benefit
	of the public at large and to the detriment of our heirs and
	successors. We intend this dedication to be an overt act of
	relinquishment in perpetuity of all present and future rights to this
	software under copyright law.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
	MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
	IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
	OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
	ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
	OTHER DEALINGS IN THE SOFTWARE.

	For more information, please refer to &lt;http://unlicense.org/&gt;
	</pre>
	<h3>TO-DO</h3>
	<ul>
		<li>Offer to switch to a <em>white on black</em> style.</li>
		<li>Support syntax highlight for CSS and Javascript</li>
	</ul>
</footer>

</article>

</body>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="js/script.js"></script>
</html>