<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/clock_widget/templates/clock-block.html.twig */
class __TwigTemplate_00e8d18e40b2a02b05ccad83f1d97138 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"clock-widget\">
  <h2>";
        // line 2
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_capitalize_string_filter($this->env, $this->sandbox->ensureToStringAllowed(($context["unique_id"] ?? null), 2, $this->source)), "html", null, true);
        echo " CLOCK</h2>
  <div class=\"clock\" data-unique-id=\"";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["unique_id"] ?? null), 3, $this->source), "html", null, true);
        echo "\" id=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["unique_id"] ?? null), 3, $this->source), "html", null, true);
        echo "\"></div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["unique_id"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "modules/custom/clock_widget/templates/clock-block.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  46 => 3,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/clock_widget/templates/clock-block.html.twig", "/var/www/html/web/modules/custom/clock_widget/templates/clock-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 2, "capitalize" => 2);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 'capitalize'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
