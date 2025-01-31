import { useState } from "react";
import {
  CheckIcon,
  PencilIcon,
  TrashIcon,
  XMarkIcon,
} from "@heroicons/react/24/outline";
import { zodResolver } from "@hookform/resolvers/zod";
import { useMutation } from "@tanstack/react-query";
import { useForm } from "react-hook-form";

import {
  City,
  handleAxiosFieldErrors,
  updateCityQuery,
  upsertCityPayloadSchema,
  type UpsertCityPayloadSchema,
} from "~/api";
import { Button, errorToast, Input, TOAST_TYPES, useToastStore } from "~/ui";
import { DeleteCityModal } from "./DeleteCityModal";

interface CityRowProps {
  city: City;
  onUpdate: () => void;
}

export const CityRow = ({ city, onUpdate }: CityRowProps) => {
  const [isEditing, setIsEditing] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const { pushToast } = useToastStore();

  const {
    register,
    handleSubmit,
    setError,
    reset,
    formState: { errors },
  } = useForm<UpsertCityPayloadSchema>({
    resolver: zodResolver(upsertCityPayloadSchema),
    defaultValues: {
      name: city.name,
    },
  });

  const updateCityMutation = useMutation({
    mutationFn: async ({ name }: UpsertCityPayloadSchema) => {
      await updateCityQuery.mutation(city.id, { name });
    },
    onSuccess: () => {
      setIsEditing(false);
      onUpdate();
      pushToast({
        type: TOAST_TYPES.success,
        title: "Success",
        message: "City updated successfully",
      });
    },
    onError: (error) => {
      handleAxiosFieldErrors(error, setError);
      errorToast(error);
    },
  });

  const onFinishEditing = () => {
    setIsEditing(false);
    reset();
  };

  if (isEditing) {
    return (
      <div className="flex items-baseline justify-between">
        <form
          onSubmit={handleSubmit((data) => updateCityMutation.mutate(data))}
          className="flex w-full items-center gap-2"
        >
          <Input
            id={city.id.toString()}
            type="text"
            compact
            {...register("name")}
            error={errors.name?.message}
            className="flex-1 rounded-md border-gray-300 shadow-sm"
            autoComplete="off"
          />
          <Button
            variant="ghost"
            type="submit"
            spacing="tight"
            className="ml-auto text-green-600 hover:opacity-75"
          >
            <CheckIcon className="size-5" />
          </Button>
          <Button
            variant="ghost"
            onClick={onFinishEditing}
            className="text-red-600 hover:opacity-75"
          >
            <XMarkIcon className="size-5" />
          </Button>
        </form>
      </div>
    );
  }

  return (
    <div className="flex items-center gap-2">
      <span className="flex-1">{city.name}</span>
      <Button
        onClick={() => {
          setIsEditing(true);
        }}
        variant="ghost"
        spacing="tight"
      >
        <PencilIcon className="size-5" />
      </Button>
      <Button
        variant="ghost"
        onClick={() => setShowDeleteModal(true)}
        spacing="tight"
        className="text-red-600 hover:opacity-75"
      >
        <TrashIcon className="size-5" />
      </Button>

      <DeleteCityModal
        city={city}
        show={showDeleteModal}
        onClose={() => setShowDeleteModal(false)}
        onDelete={onUpdate}
      />
    </div>
  );
};
