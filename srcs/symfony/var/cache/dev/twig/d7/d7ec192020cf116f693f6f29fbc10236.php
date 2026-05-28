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

/* @Mercure/Collector/mercure.html.twig */
class __TwigTemplate_e08676263453c5bc1bf8da40c28736e1 extends Template
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

        $this->blocks = [
            'toolbar' => [$this, 'block_toolbar'],
            'menu' => [$this, 'block_menu'],
            'panel' => [$this, 'block_panel'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Mercure/Collector/mercure.html.twig"));

        // line 3
        $macros["helper"] = $this->macros["helper"] = $this;
        // line 1
        $this->parent = $this->load("@WebProfiler/Profiler/layout.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_toolbar(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "toolbar"));

        // line 6
        yield "    ";
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 6, $this->source); })()), "count", [], "any", false, false, false, 6) > 0)) {
            // line 7
            yield "        ";
            $context["icon"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                // line 8
                yield "            ";
                yield Twig\Extension\CoreExtension::include($this->env, $context, "@Mercure/Icon/mercure.svg");
                yield "
            <span class=\"sf-toolbar-value\">";
                // line 9
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 9, $this->source); })()), "count", [], "any", false, false, false, 9), "html", null, true);
                yield "</span>
        ";
                yield from [];
            })())) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 11
            yield "
        ";
            // line 12
            yield Twig\Extension\CoreExtension::include($this->env, $context, "@WebProfiler/Profiler/toolbar_item.html.twig", ["link" => "mercure"]);
            yield "
    ";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 16
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_menu(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "menu"));

        // line 17
        yield "    <span class=\"label";
        yield (((CoreExtension::getAttribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 17, $this->source); })()), "count", [], "any", false, false, false, 17) == 0)) ? (" disabled") : (""));
        yield "\">
        <span class=\"icon\">";
        // line 18
        yield Twig\Extension\CoreExtension::include($this->env, $context, "@Mercure/Icon/mercure.svg");
        yield "</span>
        <strong>Mercure</strong>
    </span>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 23
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_panel(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "panel"));

        // line 24
        yield "    ";
        $macros["helper"] = $this;
        // line 25
        yield "
    <h2>Messages</h2>

    ";
        // line 28
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 28, $this->source); })()), "count", [], "any", false, false, false, 28) == 0)) {
            // line 29
            yield "        <div class=\"empty empty-panel\">
            <p>No messages have been collected.</p>
        </div>
    ";
        } else {
            // line 33
            yield "        <div class=\"sf-tabs\">
            ";
            // line 34
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 34, $this->source); })()), "hubs", [], "any", false, false, false, 34));
            foreach ($context['_seq'] as $context["name"] => $context["data"]) {
                // line 35
                yield "                <div class=\"tab\">
                    <h3 class=\"tab-title\">";
                // line 36
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["name"], "html", null, true);
                yield "<span class=\"badge\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["data"], "count", [], "any", false, false, false, 36), "html", null, true);
                yield "</span></h3>
                    <div class=\"tab-content\">
                        <div class=\"metrics\">
                            <div class=\"metric\">
                                <span class=\"value\">";
                // line 40
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%.0f", CoreExtension::getAttribute($this->env, $this->source, $context["data"], "duration", [], "any", false, false, false, 40)), "html", null, true);
                yield " <span class=\"unit\">ms</span></span>
                                <span class=\"label\">Total execution time</span>
                            </div>
                            <div class=\"metric\">
                                <span class=\"value\">";
                // line 44
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%.2f", ((CoreExtension::getAttribute($this->env, $this->source, $context["data"], "memory", [], "any", false, false, false, 44) / 1024) / 1024)), "html", null, true);
                yield " <span class=\"unit\">MB</span></span>
                                <span class=\"label\">Peak memory usage</span>
                            </div>
                        </div>

                        <table>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Time</th>
                                <th>Memory</th>
                                <th>Topics</th>
                                <th>Data</th>
                                <th>Private</th>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Retry</th>
                            </tr>
                            </thead>
                            <tbody>
                                ";
                // line 64
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["data"], "messages", [], "any", false, false, false, 64));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                    // line 65
                    yield "                                    <tr>
                                        <td class=\"font-normal text-small text-muted nowrap\">";
                    // line 66
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 66), "html", null, true);
                    yield "</td>
                                        <td class=\"nowrap\">";
                    // line 67
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%.0f", CoreExtension::getAttribute($this->env, $this->source, $context["message"], "duration", [], "any", false, false, false, 67)), "html", null, true);
                    yield " ms</td>
                                        <td class=\"nowrap\">";
                    // line 68
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::sprintf("%.2f", ((CoreExtension::getAttribute($this->env, $this->source, $context["message"], "memory", [], "any", false, false, false, 68) / 1024) / 1024)), "html", null, true);
                    yield " MB</td>
                                        <td class=\"font-normal text-small text-bold nowrap\">";
                    // line 69
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::join(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["message"], "object", [], "any", false, false, false, 69), "topics", [], "any", false, false, false, 69), ","), "html", null, true);
                    yield "</td>
                                        <td>";
                    // line 70
                    yield Twig\Extension\DebugExtension::dump($this->env, $context, ...[CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["message"], "object", [], "any", false, false, false, 70), "data", [], "any", false, false, false, 70)]);
                    yield "</td>
                                        <td>";
                    // line 71
                    yield Twig\Extension\DebugExtension::dump($this->env, $context, ...[CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["message"], "object", [], "any", false, false, false, 71), "private", [], "any", false, false, false, 71)]);
                    yield "</td>
                                        <td class=\"nowrap\">";
                    // line 72
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["message"], "object", [], "any", false, false, false, 72), "id", [], "any", false, false, false, 72), "html", null, true);
                    yield "</td>
                                        <td class=\"nowrap\">";
                    // line 73
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["message"], "object", [], "any", false, false, false, 73), "type", [], "any", false, false, false, 73), "html", null, true);
                    yield "</td>
                                        <td class=\"nowrap\">";
                    // line 74
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["message"], "object", [], "any", false, false, false, 74), "retry", [], "any", false, false, false, 74), "html", null, true);
                    yield "</td>
                                    </tr>
                                ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 77
                yield "                            </tbody>
                        </table>
                    </div>
                </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['name'], $context['data'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 82
            yield "        </div>
    ";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@Mercure/Collector/mercure.html.twig";
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
        return array (  284 => 82,  274 => 77,  257 => 74,  253 => 73,  249 => 72,  245 => 71,  241 => 70,  237 => 69,  233 => 68,  229 => 67,  225 => 66,  222 => 65,  205 => 64,  182 => 44,  175 => 40,  166 => 36,  163 => 35,  159 => 34,  156 => 33,  150 => 29,  148 => 28,  143 => 25,  140 => 24,  130 => 23,  118 => 18,  113 => 17,  103 => 16,  92 => 12,  89 => 11,  83 => 9,  78 => 8,  75 => 7,  72 => 6,  62 => 5,  54 => 1,  52 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \x27@WebProfiler/Profiler/layout.html.twig\x27 %}

{% import _self as helper %}

{% block toolbar %}
    {% if collector.count > 0 %}
        {% set icon %}
            {{ include(\x27@Mercure/Icon/mercure.svg\x27) }}
            <span class=\"sf-toolbar-value\">{{ collector.count }}</span>
        {% endset %}

        {{ include(\x27@WebProfiler/Profiler/toolbar_item.html.twig\x27, { link: \x27mercure\x27 }) }}
    {% endif %}
{% endblock %}

{% block menu %}
    <span class=\"label{{ collector.count == 0 ? \x27 disabled\x27 }}\">
        <span class=\"icon\">{{ include(\x27@Mercure/Icon/mercure.svg\x27) }}</span>
        <strong>Mercure</strong>
    </span>
{% endblock %}

{% block panel %}
    {% import _self as helper %}

    <h2>Messages</h2>

    {% if collector.count == 0 %}
        <div class=\"empty empty-panel\">
            <p>No messages have been collected.</p>
        </div>
    {% else %}
        <div class=\"sf-tabs\">
            {% for name, data in collector.hubs %}
                <div class=\"tab\">
                    <h3 class=\"tab-title\">{{ name }}<span class=\"badge\">{{ data.count }}</span></h3>
                    <div class=\"tab-content\">
                        <div class=\"metrics\">
                            <div class=\"metric\">
                                <span class=\"value\">{{ \x27%.0f\x27|format(data.duration) }} <span class=\"unit\">ms</span></span>
                                <span class=\"label\">Total execution time</span>
                            </div>
                            <div class=\"metric\">
                                <span class=\"value\">{{ \x27%.2f\x27|format(data.memory / 1024 / 1024) }} <span class=\"unit\">MB</span></span>
                                <span class=\"label\">Peak memory usage</span>
                            </div>
                        </div>

                        <table>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Time</th>
                                <th>Memory</th>
                                <th>Topics</th>
                                <th>Data</th>
                                <th>Private</th>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Retry</th>
                            </tr>
                            </thead>
                            <tbody>
                                {% for message in data.messages %}
                                    <tr>
                                        <td class=\"font-normal text-small text-muted nowrap\">{{ loop.index }}</td>
                                        <td class=\"nowrap\">{{ \x27%.0f\x27|format(message.duration) }} ms</td>
                                        <td class=\"nowrap\">{{ \x27%.2f\x27|format(message.memory / 1024 / 1024) }} MB</td>
                                        <td class=\"font-normal text-small text-bold nowrap\">{{ message.object.topics|join(\x27,\x27) }}</td>
                                        <td>{{ dump(message.object.data) }}</td>
                                        <td>{{ dump(message.object.private) }}</td>
                                        <td class=\"nowrap\">{{ message.object.id }}</td>
                                        <td class=\"nowrap\">{{ message.object.type }}</td>
                                        <td class=\"nowrap\">{{ message.object.retry }}</td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
            {% endfor %}
        </div>
    {% endif %}
{% endblock %}
", "@Mercure/Collector/mercure.html.twig", "/Users/thedon/Desktop/sharr/srcs/symfony/vendor/symfony/mercure-bundle/src/Resources/views/Collector/mercure.html.twig");
    }
}
