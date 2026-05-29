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

/* @Twig/Exception/error503.html.twig */
class __TwigTemplate_8ad601a68c3d8f01345559afe98f9076 extends Template
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
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
<meta charset=\"UTF-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
<title>503 — Service indisponible</title>
<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
<link href=\"https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
<link rel=\"stylesheet\" href=\"https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css\">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg-0:    #fafafa;
  --bg-1:    #ffffff;
  --bg-2:    #f4f4f5;
  --bg-3:    #e4e4e7;
  --line:    rgba(0,0,0,0.07);
  --line-hi: rgba(0,0,0,0.13);
  --t-0:     #09090b;
  --t-1:     #52525b;
  --t-2:     #a1a1aa;
  --t-3:     #d4d4d8;
  --blue:    #3b82f6;
  --f-ui:    \x27Geist\x27, system-ui, sans-serif;
}

html, body {
  height: 100%;
  background: var(--bg-0);
  font-family: var(--f-ui);
  color: var(--t-1);
}

/* ── NAVBAR ── */
.nav {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 52px;
  background: var(--bg-1);
  border-bottom: 1px solid var(--line);
  display: flex;
  align-items: center;
  padding: 0 16px;
  z-index: 10;
}

.logo { display: flex; align-items: center; gap: 9px; text-decoration: none; }

.logo-box {
  width: 28px; height: 28px; border-radius: 6px;
  background: var(--t-0);
  display: flex; align-items: center; justify-content: center;
}

.logo-box i { font-size: 13px; color: var(--bg-1); }

.logo-text {
  font-size: 15px; font-weight: 600;
  color: var(--t-0); letter-spacing: -0.02em;
}

/* ── MAIN ── */
body {
  display: flex;
  flex-direction: column;
}

main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 52px 24px 0;
}

.card {
  width: 100%;
  max-width: 420px;
  background: var(--bg-1);
  border: 1px solid var(--line);
  border-radius: 12px;
  padding: 40px 36px;
  text-align: center;
}

/* Error badge */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 4px;
  background: var(--bg-2);
  border: 1px solid var(--line-hi);
  font-size: 11px;
  font-weight: 600;
  color: var(--t-2);
  letter-spacing: 0.05em;
  text-transform: uppercase;
  margin-bottom: 24px;
}

.badge i { font-size: 10px; }

/* 503 number */
.code {
  font-size: 72px;
  font-weight: 700;
  color: var(--t-0);
  letter-spacing: -0.04em;
  line-height: 1;
  margin-bottom: 12px;
}

.divider {
  width: 32px;
  height: 2px;
  background: var(--t-0);
  border-radius: 2px;
  margin: 0 auto 20px;
}

.title {
  font-size: 16px;
  font-weight: 600;
  color: var(--t-0);
  letter-spacing: -0.01em;
  margin-bottom: 8px;
}

.text {
  font-size: 13px;
  color: var(--t-2);
  line-height: 1.65;
  margin-bottom: 28px;
}

/* Pulsing dot status indicator */
.status {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 6px 12px;
  border-radius: 6px;
  background: var(--bg-2);
  border: 1px solid var(--line);
  font-size: 12px;
  color: var(--t-1);
  font-weight: 500;
  margin-bottom: 28px;
}

.dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #f59e0b;
  animation: pulse 1.8s ease-in-out infinite;
  flex-shrink: 0;
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: 0.4; transform: scale(0.85); }
}

/* Button */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 0 16px;
  height: 36px;
  background: var(--t-0);
  color: var(--bg-1);
  text-decoration: none;
  border-radius: 7px;
  font-size: 13px;
  font-weight: 500;
  font-family: var(--f-ui);
  border: none;
  cursor: pointer;
  transition: opacity 0.15s;
}

.btn:hover { opacity: 0.82; }
.btn i { font-size: 12px; }

/* Footer hint */
.hint {
  margin-top: 24px;
  font-size: 11px;
  color: var(--t-3);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
}

.hint i { font-size: 10px; }
</style>
</head>
<body>

<nav class=\"nav\">
  <a href=\"";
        // line 208
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_home");
        yield "\" class=\"logo\">
    <div class=\"logo-box\"><i class=\"fi fi-sr-code-simple\"></i></div>
    <span class=\"logo-text\">Sharr</span>
  </a>
</nav>

<main>
  <div class=\"card\">
    <div class=\"badge\">
      <i class=\"fi fi-sr-wrench-simple\"></i>
      Maintenance
    </div>
    <p class=\"code\">503</p>
    <div class=\"divider\"></div>
    <p class=\"title\">On revient très vite !</p>
    <p class=\"text\">
      Sharr fait une petite pause technique.<br>
   
    </p>
    <div class=\"status\">
      <span class=\"dot\"></span>
       En cours…
    </div>
    <br>
    <button class=\"btn\" onclick=\"window.location.reload()\">
      <i class=\"fi fi-sr-rotate-right\"></i>
      Réessayer
    </button>
    <div class=\"hint\">
      <i class=\"fi fi-sr-info\"></i>
       Vous pouvez continuer à voir vos rooms existantes. 

    </div>
  </div>
</main>

</body>
</html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@Twig/Exception/error503.html.twig";
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
        return array (  251 => 208,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@Twig/Exception/error503.html.twig", "/Users/thedon/Desktop/sharr/srcs/symfony/templates/bundles/TwigBundle/Exception/error503.html.twig");
    }
}
