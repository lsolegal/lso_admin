@extends('frontend/layout/layout')
@section('section')
    <div class="container">
        <div class="row mt-2">
            <div class="col-xl-3 col-lg-12">
                <a href="{{ url('birth-chart') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Birth Chart/Kundli</h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/birth_chart.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3 p-2">
                                    <p class="m-0 subtitle">विस्तृत कुंडली से अपने जन्म के रहस्यों को जानें, ग्रहों की स्थिति के माध्यम से अपने जीवन का मार्ग खोजें।
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('match-horoscope') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Match Horoscope</h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/kundli_matching.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">अपना आदर्श ब्रह्मांडीय संबंध खोजें - कुंडली मिलाएं और भाग्य का खुलासा करें!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
    
            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('life-prediction') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Your Life Predictions </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/life_prediction.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('gochar-fal') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Gochar Phal (Transit Report)  </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/ic_transit_today.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('lal-kitab') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Lal Kitab Horoscope </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/ic_lalkitab.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('mangal-dosh') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Mangal Dosha </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/ic_mangal_dosh.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('gemstones') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Gemstones Report </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/ic_gemstone.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('my-day-today') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">my day today </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/personalized-horoscope-report.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('sade-sati') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Sade Sati Life Report </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/shani-sade-sati-report.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4">
                <a href="{{ url('kalsarp-dosh') }}">
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Kalsarp Dosh/ Yog </h4>
                        </div>
                        <div class="card-body m-0 p-0">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="front/images/kundli/kalsarp-dosh.png" alt="">
                                </div>
                                <div class="fw-bold text-center pb-3">
                                    <p class="m-0 subtitle">"करियर से लेकर प्यार तक, जानिए आगे क्या है - ज्योतिष के माध्यम से आपका भविष्य।"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection