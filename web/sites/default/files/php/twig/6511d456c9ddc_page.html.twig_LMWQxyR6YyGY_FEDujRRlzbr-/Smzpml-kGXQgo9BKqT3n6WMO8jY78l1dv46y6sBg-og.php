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

/* themes/nativebiodata/templates/layout/page.html.twig */
class __TwigTemplate_03793bb189de8c83efae72d5649e7dce extends Template
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
        // line 45
        echo "<div class=\"layout-container\">

  <div class=\"secondary-menu\">
    <div class=\"container\">
      ";
        // line 49
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 49), 49, $this->source), "html", null, true);
        echo "
    </div>
  </div>
  <header class=\"container\" role=\"banner\">
    ";
        // line 53
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 53), 53, $this->source), "html", null, true);
        echo "
  </header>

  <div class=\"container w-100 justify-content-evenly nav-container\">
    ";
        // line 57
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 57), 57, $this->source), "html", null, true);
        echo "
  </div>

  ";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "

  ";
        // line 62
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
        echo "

  ";
        // line 64
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 64), 64, $this->source), "html", null, true);
        echo "

  <main role=\"main\" class=\"container\">
    <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 68
        echo "
    <div class=\"layout-content\">
      ";
        // line 70
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
        echo "
    </div>";
        // line 72
        echo "
    ";
        // line 73
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 73)) {
            // line 74
            echo "      <aside class=\"layout-sidebar-first\" role=\"complementary\">
        ";
            // line 75
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 75), 75, $this->source), "html", null, true);
            echo "
      </aside>
    ";
        }
        // line 78
        echo "
    ";
        // line 79
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 79)) {
            // line 80
            echo "      <aside class=\"layout-sidebar-second\" role=\"complementary\">
        ";
            // line 81
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 81), 81, $this->source), "html", null, true);
            echo "
      </aside>
    ";
        }
        // line 84
        echo "
  </main>

  ";
        // line 87
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 87)) {
            // line 88
            echo "    <footer class=\"main-footer\" role=\"contentinfo\">
      <div class=\"container\">
        ";
            // line 90
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 90), 90, $this->source), "html", null, true);
            echo "
      </div>
    </footer>
  ";
        }
        // line 94
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "themes/nativebiodata/templates/layout/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 94,  128 => 90,  124 => 88,  122 => 87,  117 => 84,  111 => 81,  108 => 80,  106 => 79,  103 => 78,  97 => 75,  94 => 74,  92 => 73,  89 => 72,  85 => 70,  81 => 68,  75 => 64,  70 => 62,  65 => 60,  59 => 57,  52 => 53,  45 => 49,  39 => 45,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/nativebiodata/templates/layout/page.html.twig", "C:\\xampp4\\htdocs\\nbd\\web\\themes\\nativebiodata\\templates\\layout\\page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 73);
        static $filters = array("escape" => 49);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
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
