<?php
include('server.php');

if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        if ($_SESSION['role'] != 'Employee') {
            if ($_SESSION['role'] != 'User') {
                header("location: logout.php");
                exit;
            }
        }
    }
}

include('includes/head.php');
?>

<body>
    <div class="container">

        <?php include('includes/jumbotron.php') ?>

        <?php
        include('includes/messages.php');
        ?>

        <div class="row">
            <main class="col-sm-8" style="background-color: rgb(165, 176, 189);">
                <article id="art-001" class="m-2 p-2 border border-secondary">
                    <h3>Article 001-ACTIVITY BACKGROUND</h3>
                    <p>The PRICE project is operating under the National Agricultural Export Development Board in the Ministry of Agriculture and Animal Resources. PRICE is a 7 years’ project, $67-million-dollar initiative funded by loan and a grant from IFAD that builds on the progress of the concluded PDCRE (cash and export crops development) project. PRICE’s goal is to raise smallholder farmers’ income through greater sustainable by increasing the volume and quality of crop production, improved marketing, and more effective farmer organizations.
                        Therefore, NAEB/PRICE has received horticulture business ideas from different farmers requesting for the grant on their projects.
                        All these farmers were requested to fill information about their business ideas on the forms provided by PRICE and they had to be submitted to PRICE’s office.
                    </p>
                </article>
                <article id="art-002" class="m-2 p-2 border border-secondary">
                    <h3>Article 002-ACTIVITY OBJECTIVES</h3>
                    <p>The main objective of the activity is to receive horticulture business ideas from different business ideas owners requesting for grants on their projects.
                        The specific objectives are: <br>
                        <li> To receive the forms of horticulture business ideas.</li>
                        <li>To record the forms of horticulture business ideas</li>
                        <li>To facilitate the task force in charge of horticulture business ideas screening.</li>
                        <li>Checking and filing corrected forms of horticulture business ideas.</li>
                        <li>To communicate to farmers and service providers about the output of submitted horticulture business ideas.</li>
                    </p>
                </article>
                <article id="art-003" class="m-2 p-2 border border-secondary">
                    <h3>Article 003-EXPECTED RESULTS</h3>
                    <p>The PRICE project is operating under the National Agricultural Export Development Board in the Ministry of Agriculture and Animal Resources. PRICE is a 7 years’ project, $67-million-dollar initiative funded by loan and a grant from IFAD that builds on the progress of the concluded PDCRE (cash and export crops development) project. PRICE’s goal is to raise smallholder farmers’ income through greater sustainable by increasing the volume and quality of crop production, improved marketing, and more effective farmer organizations.
                        Therefore, NAEB/PRICE has received horticulture business ideas from different farmers requesting for the grant on their projects.
                        All these farmers were requested to fill information about their business ideas on the forms provided by PRICE and they had to be submitted to PRICE’s office.
                        At the end of this activity, we expected to have a list of all business ideas received and that list should be signed by the business applicants. We also expected to have a database of all business ideas received that contain all information written on their application forms. After all, business ideas were classified and archived.</p>
                </article>
            </main>

            <aside id="sidebar" class="col-sm-4 bg-secondary text-white">
                <div style="margin: 20px">
                    <a href="all.php"><button id="backHome" type="button" class="btn-success btn-sm">View Results</button></a>
                    <a href="naeb.gov.rw"><button id="backHome" type="button" class="btn-success btn-sm">Visit NAEB Website</button></a>
                </div>
            </aside>

        </div>
        <?php
        include('includes/footer.php');
        ?>
    </div>

</body>

</html>