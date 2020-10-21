@extends('layouts.app',['title'=>'Teacher Recruitment'])
@section('title', 'Teacher Recruitment')
@section('content')
    <section class="sub_page_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="sub_page_header rec">Be passionate. Be amazing. Be fun. Be an amazing Accent
                        teacher.</h4>
                </div>
            </div>
            <div class="aboutus_detail_box">
                <div class="row">
                    <div class="col-12">
                        <div class="recruitment_margin">
                            <p>We would like to invite you to become a passionate and amazing language teacher at
                                Accent. Passionate by helping a person find a better quality of life through learning a
                                language and amazing because as a professional language teacher, your lesson materials
                                and methods are new, energising, creative, fun and inspirational, every lesson. These
                                elements produce positive results in your clients.</p>

                            <h4>We are different.</h4>
                            <p>The biggest difference at Accent is the use of OnePage. An online learning tool which
                                encourages good study habits by making it easier for clients to review and use the
                                target language. Every clients’ language learning needs are different. Using OnePage
                                enables the teacher to match each and every students’ topics of interest or learning
                                goals to various lesson materials and methods available both on and off-line, which make
                                OnePage a truly customisable learning and teaching tool. OnePage becomes the client’s
                                living textbook.</p>
                            <p>At Accent we take the pain out of having your clients schedule a lesson and managing
                                payments so that you can focus on what you do best, teach amazing lessons. These are the
                                other differences. Our online scheduling system ensures that both teachers and clients
                                receive timely notifications. Our online payments system ensures that no payments are
                                missed and are properly accounted for. Philippine Online and Cafe Premium teachers can
                                receive payments via PayPal daily.</p>
                            <p>At Accent, we are seeking teachers to teach in the following ways:</p>
                            <ol type="1">
                                <li>If you live in Japan:
                                    <ol class="list" style="margin-left: 30px;" type="a">
                                        <li>In the classroom with Skype as an alternative.</li>
                                        <li>In cafes nearby train stations throughout Japan or the client’s office with
                                            Skype as an alternative.
                                        </li>
                                    </ol>
                                </li>
                                <li>If you live outside Japan, on Skype.</li>
                            </ol>

                            <h4>How much do I get paid per lesson?</h4>
                            <p>Teaching lesson per lesson gives&nbsp;you the flexibility to earn a supplementary income.
                                The number of lessons you teach depends on student demand. Accent will do its best to
                                generate new students however since demand for lessons will invariably fluctuate, please
                                view teaching lesson per lesson as a way to supplement your main income. There are
                                teachers who do get paid well for being passionate and teaching amazing lessons.</p>
                            <p>We offer very competitive rates for teachers teaching in Japan or from other countries.
                                It really depends&nbsp;on how many hours you have taught along with any teaching
                                qualifications you may have. Please apply for a teaching position here to find out
                                more.</p>
                            <h4>OJT - On the job training.</h4>
                            <p>We deliver OJT either on Skype or in person. Over 4 sessions, teachers will learn and be
                                trained in the following:</p>
                            <ul class="list circle-list opacityRun">
                                <li>
                                    <i class="fas fa-chevron-right"> </i>Teaching at Accent, our mission and goals.
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"> </i>Using the Accent Lesson Management System (ALMS).
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"> </i> Using OnePage.
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"> </i>Lesson observations.
                                </li>
                            </ul>
                            <h4>The Application process is simple.</h4>
                            <p>Just register your interest here and follow the directions sent to you via email in the
                                lead up to the interview on Skype or in person.</p>
                            <p>We are looking forward to you joining Accent. Welcome.
                                <a style="background: #002e58; color: #ffffff;padding: 3px;font-size: 16px;" href="{{ route('teachers.register.index') }}">
                                    <span class="highlight"><b> Please apply here</b></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection