<button data-bs-toggle="modal" data-bs-target="#staticBackdrop"   id=""class="btn m-2 my-btn btn-outline-dark">Feedback</button>  
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Feedback</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			

				<div class="modal-body">
					<form method="post" class="needs-validation" action="new_feedback.php" enctype= "multipart/form-data"> 
						<input type="hidden" readonly id="event_fb_id" name="event_fb_id" value="'.$result[$key]['event_id'].'"></input>
						<input type="hidden" readonly id="user_fb_id" name="user_fb_id" value="'.$user_id.'"></input>
						<div class="m-3 form-group ">
							<p>Feedback</p>
							<div class="form-group ">
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
							</div>
						</div>

						<div class="m-3 form-group ">
							<div class="d-grid gap-2 ">
								<button type="submit" class="g-col-4 btn btn-outline-dark">Submit</button>
								<button type="reset" class="g-col-4 btn btn-outline-secondary">Reset</button>
							</div>    
						</div>              
					</form>                            
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>   