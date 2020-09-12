<?php

/* master.twig */
class __TwigTemplate_bb8846a8676aa4fd7c68289282e58d00b2031c17a9a33c90c522ead3f6ac1af8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html ng-app>
<head>
    <title>";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</title>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["meta"]) ? $context["meta"] : null));
        foreach ($context['_seq'] as $context["metaname"] => $context["metavalue"]) {
            // line 9
            echo "    <meta name=\"";
            echo twig_escape_filter($this->env, $context["metaname"], "html", null, true);
            echo "\" value=\"";
            echo twig_escape_filter($this->env, $context["metavalue"], "html", null, true);
            echo "\" />
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['metaname'], $context['metavalue'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "
    <!-- publish javascript variable -->
    <script>
        var global = ";
        // line 14
        echo twig_jsonencode_filter((isset($context["global"]) ? $context["global"] : null));
        echo "
    </script>

    <!-- Include registered css -->
    ";
        // line 18
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["css"]) ? $context["css"] : null), "external", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["cssfile"]) {
            // line 19
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, $context["cssfile"], "html", null, true);
            echo "\" />
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cssfile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "
    ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["css"]) ? $context["css"] : null), "internal", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["cssfile"]) {
            // line 23
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["assetUrl"]) ? $context["assetUrl"] : null), "html", null, true);
            echo "css/";
            echo twig_escape_filter($this->env, $context["cssfile"], "html", null, true);
            echo "\" />
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cssfile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "</head>
<body>
    ";
        // line 27
        $this->displayBlock('body', $context, $blocks);
        // line 28
        echo "
    <!-- Include registered javascript -->
    ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["js"]) ? $context["js"] : null), "external", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["jsfile"]) {
            // line 31
            echo "    <script src=\"";
            echo twig_escape_filter($this->env, $context["jsfile"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['jsfile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "
    ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["js"]) ? $context["js"] : null), "internal", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["jsfile"]) {
            // line 35
            echo "    <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["assetUrl"]) ? $context["assetUrl"] : null), "html", null, true);
            echo "js/";
            echo twig_escape_filter($this->env, $context["jsfile"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['jsfile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "</body>
</html>";
    }

    // line 27
    public function block_body($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "master.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  136 => 27,  131 => 37,  120 => 35,  116 => 34,  113 => 33,  104 => 31,  100 => 30,  96 => 28,  94 => 27,  90 => 25,  79 => 23,  75 => 22,  72 => 21,  63 => 19,  59 => 18,  52 => 14,  47 => 11,  36 => 9,  32 => 8,  25 => 4,  20 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html ng-app>*/
/* <head>*/
/*     <title>{{ title }}</title>*/
/*     <meta charset="utf-8">*/
/*     <meta name="viewport" content="width=device-width, initial-scale=1.0">*/
/* */
/*     {% for metaname, metavalue in meta %}*/
/*     <meta name="{{metaname}}" value="{{metavalue}}" />*/
/*     {% endfor %}*/
/* */
/*     <!-- publish javascript variable -->*/
/*     <script>*/
/*         var global = {{global|json_encode|raw}}*/
/*     </script>*/
/* */
/*     <!-- Include registered css -->*/
/*     {% for cssfile in css.external %}*/
/*     <link rel="stylesheet" href="{{cssfile}}" />*/
/*     {% endfor %}*/
/* */
/*     {% for cssfile in css.internal %}*/
/*     <link rel="stylesheet" href="{{assetUrl}}css/{{cssfile}}" />*/
/*     {% endfor %}*/
/* </head>*/
/* <body>*/
/*     {% block body %}{% endblock %}*/
/* */
/*     <!-- Include registered javascript -->*/
/*     {% for jsfile in js.external %}*/
/*     <script src="{{jsfile}}"></script>*/
/*     {% endfor %}*/
/* */
/*     {% for jsfile in js.internal %}*/
/*     <script src="{{assetUrl}}js/{{jsfile}}"></script>*/
/*     {% endfor %}*/
/* </body>*/
/* </html>*/
