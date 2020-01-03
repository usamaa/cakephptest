<div class="page-header header-filter">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-6 ml-auto mr-auto">
                <div class="card card-login">

                    <?php
                    echo $this->Form->create(null, ['url' => [
                        'action' => 'view',
                        'controller' => 'Home'
                    ]
                    ]);

                    ?>
                        <div class="card-body">
                            <div class="input-group">
                                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">face</i>
                    </span>
                                </div>
                                <input type="number" name="plaintiff" class="form-control" placeholder="Number of Plaintiff(s)...">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-users"></i>
                    </span>
                                </div>
                                <input type="number" name="defendent" class="form-control" placeholder="Number of Defendent(s)...">
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="dncr" > DNCR
                                        <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="idncl" > IDNCL
                                        <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="tiaa" > TIAA
                                        <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit"  class="btn btn-primary  btn-lg">Process</button>
                        </div>
                    </form>

                </div>
                <div class="card">

                   <div class="card-body">
                       <h3>Message</h3>
                       <?= $message ?>
                   </div>
                </div>
            </div>
        </div>
    </div>

</div>
