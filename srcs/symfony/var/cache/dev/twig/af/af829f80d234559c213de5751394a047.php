<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* Home/reader.html.twig */
class __TwigTemplate_8e5d8bf89f41225b7acfcc9fc152b7dc extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "Home/reader.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>Sharr — ";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["token"]) || array_key_exists("token", $context) ? $context["token"] : (function () { throw new RuntimeError('Variable "token" does not exist.', 6, $this->source); })()), "html", null, true);
        yield "</title>
  <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
  <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
  <link href=\"https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=JetBrains+Mono:ital,wght@0,400;0,500;1,400&display=swap\" rel=\"stylesheet\">
  <link rel=\"stylesheet\" href=\"https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css\">
  <link rel=\"stylesheet\" href=\"";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/sharr.css"), "html", null, true);
        yield "\">
</head>
<body data-theme=\"light\">

  <nav class=\"nav\">
    <div class=\"nav-l\">
      <a href=\"#\" class=\"logo\">
        <div class=\"logo-box\"><i class=\"fi fi-sr-code-simple\"></i></div>
        <span class=\"logo-text\">Sharr</span>
      </a>
      <div class=\"sep\"></div>
      <button class=\"btn\" id=\"copyLinkBtn\">
        <i class=\"fi fi-sr-copy-alt\"></i>
        <span id=\"copyLinkLabel\">Lien</span>
      </button>
    </div>
    <div class=\"nav-r\">
      <div class=\"toggle\" id=\"themeToggle\">
        <div class=\"toggle-knob\"><i class=\"fi fi-sr-moon\" id=\"themeIcon\"></i></div>
      </div>
      <button class=\"btn\" id=\"historyBtn\">
        <i class=\"fi fi-sr-time-past\"></i>
        Historique
      </button>
    </div>
  </nav>

  <div class=\"sidebar\" id=\"sidebar\">
    <div class=\"sb-head\">
      <span class=\"sb-head-title\">Historique</span>
      <button class=\"icon-btn\" id=\"closeSidebar\"><i class=\"fi fi-sr-cross-small\"></i></button>
    </div>
    <div class=\"sb-scroll\" id=\"historyList\"></div>
  </div>

  <div class=\"shell\">
    <div class=\"body\">
      <div class=\"linenos\" id=\"lines\"></div>
      <div class=\"zone\">
        <textarea id=\"input\" spellcheck=\"false\" readonly>";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["item"]) || array_key_exists("item", $context) ? $context["item"] : (function () { throw new RuntimeError('Variable "item" does not exist.', 50, $this->source); })()), "html", null, true);
        yield "</textarea>
        <pre id=\"output\"></pre>
      </div>
    </div>
    <div class=\"statusbar\">
      <div class=\"st blue\"><i class=\"fi fi-sr-circle-small\"></i><span id=\"stLang\">Txt</span></div>
      <div class=\"st\"><i class=\"fi fi-sr-text\"></i><span id=\"stChars\">0 car.</span></div>
      <div class=\"st right\"><i class=\"fi fi-sr-eye\"></i><span>Lecture seule</span></div>
    </div>
  </div>

 <script src=\"";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/sharr-hist.js"), "html", null, true);
        yield "\"></script>
<script src=\"";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/sharr-read.js"), "html", null, true);
        yield "\"></script>
</body>
</html>";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "Home/reader.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  120 => 62,  116 => 61,  102 => 50,  60 => 11,  52 => 6,  45 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>Sharr — {{ token }}</title>
  <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
  <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
  <link href=\"https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=JetBrains+Mono:ital,wght@0,400;0,500;1,400&display=swap\" rel=\"stylesheet\">
  <link rel=\"stylesheet\" href=\"https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css\">
  <link rel=\"stylesheet\" href=\"{{ asset(\x27css/sharr.css\x27) }}\">
</head>
<body data-theme=\"light\">

  <nav class=\"nav\">
    <div class=\"nav-l\">
      <a href=\"#\" class=\"logo\">
        <div class=\"logo-box\"><i class=\"fi fi-sr-code-simple\"></i></div>
        <span class=\"logo-text\">Sharr</span>
      </a>
      <div class=\"sep\"></div>
      <button class=\"btn\" id=\"copyLinkBtn\">
        <i class=\"fi fi-sr-copy-alt\"></i>
        <span id=\"copyLinkLabel\">Lien</span>
      </button>
    </div>
    <div class=\"nav-r\">
      <div class=\"toggle\" id=\"themeToggle\">
        <div class=\"toggle-knob\"><i class=\"fi fi-sr-moon\" id=\"themeIcon\"></i></div>
      </div>
      <button class=\"btn\" id=\"historyBtn\">
        <i class=\"fi fi-sr-time-past\"></i>
        Historique
      </button>
    </div>
  </nav>

  <div class=\"sidebar\" id=\"sidebar\">
    <div class=\"sb-head\">
      <span class=\"sb-head-title\">Historique</span>
      <button class=\"icon-btn\" id=\"closeSidebar\"><i class=\"fi fi-sr-cross-small\"></i></button>
    </div>
    <div class=\"sb-scroll\" id=\"historyList\"></div>
  </div>

  <div class=\"shell\">
    <div class=\"body\">
      <div class=\"linenos\" id=\"lines\"></div>
      <div class=\"zone\">
        <textarea id=\"input\" spellcheck=\"false\" readonly>{{ item }}</textarea>
        <pre id=\"output\"></pre>
      </div>
    </div>
    <div class=\"statusbar\">
      <div class=\"st blue\"><i class=\"fi fi-sr-circle-small\"></i><span id=\"stLang\">Txt</span></div>
      <div class=\"st\"><i class=\"fi fi-sr-text\"></i><span id=\"stChars\">0 car.</span></div>
      <div class=\"st right\"><i class=\"fi fi-sr-eye\"></i><span>Lecture seule</span></div>
    </div>
  </div>

 <script src=\"{{ asset(\x27js/sharr-hist.js\x27) }}\"></script>
<script src=\"{{ asset(\x27js/sharr-read.js\x27) }}\"></script>
</body>
</html>", "Home/reader.html.twig", "/var/www/html/templates/Home/reader.html.twig");
    }
}
