
var app = angular.module("discourse");
app.directive("dialog", dialog);

function dialog($timeout)
{
	return {
		scope:
		{
			okButton: '@',
			okCallback: '=',
			cancelButton: '@',
			cancelCallback: '=',
			open: '=',
			title: '@',
			width: '@',
			height: '@',
			show: '@',
			hide: '@',
			//autoOpen: '@',
			resizable: '@',
			closeOnEscape: '@',
			validate: '@',
			validateRules: '=',
			dialogClass: '@',
			stack: '@'
		},
		replace: false,
		transclude: true,
		template: '<div><div class="error" ng-show="error"><span>{{error}}</span></div><form class="Validate" ng-transclude></form></div>',
		link: function($scope, $element, $attrs)
		{
			var dlgOpt =
			{
				autoOpen: $attrs.autoOpen || false,
				title: $attrs.title,
				width: $attrs.width || 500,
				height: $attrs.height || 250,
				modal: $attrs.modal !== false,
				show: $attrs.show || { effect: 'fade', duration: 200 },
				hide: $attrs.hide || { effect: 'fade', duration: 200 },
				draggable: $attrs.draggable || true,
				resizable: $attrs.resizable,
				closeOnEscape: $attrs.closeOnEscape || false,
				buttons: [],
				dialogClass: $attrs.dialogClass || "",
				stack: $attrs.stack || false
			};

			var validate = $attrs.validate 
				&& $attrs.validate.toLowerCase() != "false";

			var defaultClose = function() { $scope.open = false; };
			var okCallback = function()
			{
				if(validate)
					if(!$($element).find("form.Validate").valid()) return;

				if($attrs.okCallback)
					$scope.$apply($scope.okCallback());
				else
					$scope.$apply(defaultClose());
			};

			var cancelCallback = function()
			{
				if(validate) $scope.validator.resetForm();

				if($attrs.cancelCallback)
					$scope.$apply($scope.cancelCallback());
				else
					$scope.$apply(defaultClose());
			};

			if($attrs.okButton)
			{
				var okBtn = { text: $attrs.okButton };
				okBtn.click = okCallback;
				dlgOpt['buttons'].push(okBtn);
			}

			if($attrs.cancelButton)
			{
				var cancelBtn = { text: $attrs.cancelButton };
				cancelBtn.click = cancelCallback;
				dlgOpt['buttons'].push(cancelBtn);
			}

			/*$timeout(function()
			{
				$($element).dialog(dlgOpt);
			},
			0);*/

			$($element).dialog(dlgOpt);
			var close = $($element).closest('.ui-dialog')
				.find(".ui-dialog-titlebar-close");
			close.off("click");
			close.on("click", cancelCallback);

			// Validation
			if(validate)
			{
				$.extend(jQuery.validator.messages,
					{
						required: "Required"
					}
				);

				function invalidThunk(event, validator)
				{
					$scope.$apply($scope.InvalidHandler(event, validator));
				}

				function placementThunk(error, element)
				{
					$scope.$apply($scope.ErrorPlacement(error, element));
				}

				var valOpt =
				{
					invalidHandler: invalidThunk,
					errorPlacement: placementThunk,
					ignore: ":hidden:not(.Validate)"
				};

				if($scope.validateRules) valOpt.rules = $scope.validateRules;

				$scope.validator =
					$($element).find("form.Validate").validate(valOpt);
			}

			$scope.InvalidHandler = function(event, validator)
			{
				var errors = validator.numberOfInvalids();
				if(errors)
				{
					$scope.error = errors == 1 ?
						'You missed 1 required field. It has been highlighted'
						: 'You missed ' + errors +
						' required fields. They have been highlighted.';
				}
				else
					$scope.error = "";
			};

			$scope.ErrorPlacement = function(error, element)
			{
				if($(element).hasClass("Grouped"))
					error.insertAfter($(element).parents(".InputGroup"));
				else
					error.insertAfter(element);
			};

			$scope.$watch('open', function(val)
			{
				if(val == true)
				{
					$($element).dialog("open");
				}
				else
				{
					$($element).dialog("close");
					$scope.error = "";
				}
			});

			$scope.$watch('validateRules', function(val)
			{
				if(!$scope.validator || !val) return;
				var opt = $scope.validator.settings;
				$.extend(opt,
					{
						rules: val
					}
				);
			});

			$scope.$on('$destroy', function()
			{
				$element.closest('.ui-dialog').empty().remove();
			});

			$attrs.$observe('title', function(val)
			{
				$($element).dialog("option", "title", val);
			});
		}
	};
}


