<?php

/* welcome.twig */
class __TwigTemplate_aba64d798935045fc853aae18b28943f86d13b24a562360f4fad65719e5b6fbe extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("master.twig", "welcome.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "master.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-lg-12 text-center\">
            <h3 class=\"page-header\">Welcome to SlimStarter</h3>
            <p>Working with Slim in MVC environment</p>
        </div>
        <div class=\"col-lg-6\">
            <a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->site("doc"), "html", null, true);
        echo "\" class=\"btn btn-primary pull-right\">Read the Documentation</a>
        </div>
        <div class=\"col-lg-6\">
            <a href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->site("login"), "html", null, true);
        echo "\" class=\"btn btn-success\">Login to Dashboard Page</a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->
";
    }

    public function getTemplateName()
    {
        return "welcome.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 14,  40 => 11,  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends 'master.twig' %}*/
/* */
/* {% block body %}*/
/* <div class="container">*/
/*     <div class="row">*/
/*         <div class="col-lg-12 text-center">*/
/*             <h3 class="page-header">Welcome to SlimStarter</h3>*/
/*             <p>Working with Slim in MVC environment</p>*/
/*         </div>*/
/*         <div class="col-lg-6">*/
/*             <a href="{{siteUrl('doc')}}" class="btn btn-primary pull-right">Read the Documentation</a>*/
/*         </div>*/
/*         <div class="col-lg-6">*/
/*             <a href="{{siteUrl('login')}}" class="btn btn-success">Login to Dashboard Page</a>*/
/*         </div>*/
/*         <!-- /.col-lg-12 -->*/
/*     </div>*/
/*     <!-- /.row -->*/
/* </div>*/
/* <!-- /.container -->*/
/* {% endblock %}*/
